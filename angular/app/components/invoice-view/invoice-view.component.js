class InvoiceViewController{
  constructor ($stateParams, APIinvoice) {
    'ngInject'

    this.APIinvoice = APIinvoice;
    this.exist      = false

    let invoiceId   = $stateParams.invoiceId

    let data = {
           idFactura    : invoiceId
    }

    this.APIinvoice.all('invoices/view').post(data).then(
      (res) => {

        if(res.success) {

          this.exist      = true
          this.client     = res.cliente
          this.enterprise = res.empresa
          this.invoice    = res.factura
          this.details    = res.detalles

        }
     })
  }

  $onInit () {}
}

export const InvoiceViewComponent = {
    templateUrl: './views/app/components/invoice-view/invoice-view.component.html',
    controller: InvoiceViewController,
    controllerAs: 'vm',
    bindings: {}
}
