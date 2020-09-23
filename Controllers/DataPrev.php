<?php

namespace AldirBlanc\Controllers;

use DateTime;
use Exception;
use DateInterval;
use MapasCulturais\i;
use League\Csv\Writer;
use MapasCulturais\App;
use MapasCulturais\Entities\Registration;


/**
 * Registration Controller
 *
 * By default this controller is registered with the id 'registration'.
 *
 *  @property-read \MapasCulturais\Entities\Registration $requestedEntity The Requested Entity
 */
// class AldirBlanc extends \MapasCulturais\Controllers\EntityController {
class DataPrev extends \MapasCulturais\Controllers\Registration
{
    protected $config = [];

    public function __construct()
    {
        parent::__construct();

        $app = App::i();

        $this->config = $app->plugins['AldirBlanc']->config;
        $this->entityClassName = '\MapasCulturais\Entities\Registration';
        $this->layout = 'aldirblanc';
    }

    public function GET_export()
    {
        $this->requireAuthentication();
        $app = App::i();
        $app->user->is("admin");

        $opportunity_id = 1;

        /**
         * Recebe e verifica os dados contidos no endpoint
         * https://localhost:8080/from:2020-09-01/to:2020-09-30/
         * @var string $startDate
         * @var string $finishDate
         * @var \DateTime $date
         */
        if (!empty($this->data)) {

            if (!preg_match("/^[0-9]{4}-[0-9]{1,2}-[0-9]{1,2}$/", $this->data['from']) ||
                !preg_match("/^[0-9]{4}-[0-9]{1,2}-[0-9]{1,2}$/", $this->data['to'])) {

                throw new \Exception("O formato da data é inválido.");

            } else {
                $startDate = $this->data['from'];
                $finishDate = $this->data['to'];
            }

        } else {
            $date = new DateTime();  
            $finishDate = $date->format('Y-m-d 23:59');          
            $startDate = $date->sub(new DateInterval('P7D'));
            
        }
       
        $opportunity = $app->repo('Opportunity')->find($opportunity_id);
        $this->registerRegistrationMetadata($opportunity);

        /**
         * Busca os registros no banco de dados         *
         * @var string $startDate
         * @var string $finishDate
         * @var string $dql
         */
        $dql = "
        SELECT
            e
        FROM
            MapasCulturais\Entities\Registration e
        WHERE
            e.sentTimestamp >= :startDate AND
            e.sentTimestamp <= :finishDate AND
            e.status = 1 AND
            e.opportunity = :opportunity_Id";

        $query = $app->em->createQuery($dql);
        $query->setParameters([
            'opportunity_Id' => $opportunity_id,
            'startDate' => $startDate,
            'finishDate' => $finishDate,
        ]);
        $registrations = $query->getResult();

        if(empty($registrations)){
            echo "Não existe registros para o intervalo selecionado ". $startDate . " - " . $finishDate;
            die();
        }
        
        /**
         * Importa as configurações
         */
        require dirname(__DIR__) . '/config-csv-inciso1.php';              

        /**
         * Itera sobre os registros mapeados
         * @var array $data_candidate
         * @var array $data_familyGroup
         * @var int $cpf
         */
        $data_candidate = [];
        $data_familyGroup = [];
        foreach ($registrations as $key_registrations => $registration) {
            foreach ($fields as $key_fields => $column) {
                if ($key_fields != "FAMILIARCPF" && $key_fields != "GRAUPARENTESCO") {

                    if (is_callable($column)) {
                        $data_candidate[$key_registrations][$key_fields] = $column($registration);

                        if ($key_fields == "CPF") {
                            $cpf = $column($registration);

                        }

                    } else if (is_string($column) && strlen($column) > 0) {
                        $data_candidate[$key_registrations][$key_fields] = $registration->$column;

                    } else {
                        $data_candidate[$key_registrations][$key_fields] = $column;

                    }
                } else {
                    $data_candidate[$key_registrations][$key_fields] = null;

                    foreach ($registration->$column as $key_familyGroup => $familyGroup) {
                        foreach ($headers as $key => $value) {
                            if ($value == "CPF") {
                                $data_familyGroup[$key_registrations][$key_familyGroup][$value] = $cpf;

                            } elseif ($value == "FAMILIARCPF") {
                                $data_familyGroup[$key_registrations][$key_familyGroup][$value] = $familyGroup->cpf;

                            } elseif ($value == "GRAUPARENTESCO") {
                                $data_familyGroup[$key_registrations][$key_familyGroup][$value] = $familyGroup->relationship;

                            } else {
                                $data_familyGroup[$key_registrations][$key_familyGroup][$value] = null;

                            }
                        }

                    }
                }
            }
        }
        
        /**
         * Prepara as linhas do CSV
         * @var array $data_candidate
         * @var array $data
         */
        foreach ($data_candidate as $key_candidate => $candidate) {
            $data[] = $candidate;

            if (isset($data_familyGroup[$key_candidate])) {
                foreach ($data_familyGroup[$key_candidate] as $key_familyGroup => $familyGroup) {

                    foreach ($headers as $key_header => $header) {

                        if ($header == "FAMILIARCPF") {
                            $data[] = $familyGroup;
                        }
                    }
                }
            }
        }

        /**
         * Cria o CSV
         */
        $csv = Writer::createFromString("");

        $csv->insertOne($headers);

        foreach ($data as $key_csv => $csv_line) {
            $csv->insertOne($csv_line);

        }

        $csv->output('inciso1-' . md5(json_encode($data)) . '.csv');
    }

}
