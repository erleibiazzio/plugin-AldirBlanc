
<label>Observações: <br>

    <textarea ng-if="data.multiplePayments == false" ng-model="data.editPayment.metadata.csv_line.OBSERVACOES" cols="90" rows="5"></textarea>
    <textarea ng-if="data.multiplePayments == true" ng-model="data.editMultiplePayments.obs" cols="90" rows="5"></textarea>
</label>
