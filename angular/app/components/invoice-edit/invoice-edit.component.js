class InvoiceEditController{

  constructor(APIinvoice, DTOptionsBuilder, DTColumnDefBuilder, $state, $stateParams) {
      'ngInject';

      this.APIinvoice            = APIinvoice;
      this.$state                = $state
      this.exist                 = false
      this.dtColumns             = {}
      this.deleteList            = null
      this.detailList            = null
      this.newestList            = null
      this.oldestList            = null

      this.dtColumnDefs         = [DTColumnDefBuilder.newColumnDef(2).notSortable()];
      this.dtOptions            = DTOptionsBuilder.newOptions()
                                                  .withOption('paging', true)
                                                  .withOption('searching', true)
                                                  .withOption('info', true)
                                                  .withOption('responsive', true)
                                                  .withOption('FixedHeader', true)
                                                  .withOption('order', [[0, 'desc']])
                                                  .withBootstrap();

    this.invoiceId   = $stateParams.invoiceId

    let data = {
           idFactura    : this.invoiceId
    }

    this.APIinvoice.all('invoices/view').post(data).then(
      (res) => {

        if(res.success) {

          this.exist        = true
          this.client       = res.cliente
          this.enterprise   = res.empresa
          this.invoice      = res.factura
          this.detailList   = res.detalles

        }
     })

   }

    $onInit() {

    }

    onCancel() {

      swal('Cancelado', 'Los detalles de la factura no seran modificados', 'error')
      this.$state.reload()

    }

    onUpdate() {

      this.newestList = []
      this.oldestList = []
      this.detailList.forEach(element => {
        if (typeof element.id == 'undefined') {
          this.newestList.push(element)
        } else {
          this.oldestList.push(element)
        }

      })
      var vm          = this
      let $state      = this.$state
      swal({
        title: 'Quieres modificar la factura ?',
        text: 'Al presionar el boton Continuar se modificara la factura',
        type: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Continuar',
        cancelButtonText: 'No, cancelar!',
        closeOnConfirm: false,
        closeOnCancel: false
      }, (isConfirm) => {

        if (isConfirm) {

          let data = {
                 newestList     : vm.newestList,
                 oldestList     : vm.oldestList,
                 deleteList     : vm.deleteList,
                 invoiceId      : vm.invoiceId,
                 enterpriseId   : vm.enterprise.id,
          }

          this.APIinvoice.all('invoices/edit').post(data).then(
            (res) => {
              console.log(res)
           })

          swal('Procesado!', 'La factura ha sido modificada con exito.', 'success')
          $state.reload()
        } else {
          swal('Cancelado', 'Puede continuar con los detalles de la factura', 'error')
        }
      })

    }

    onNewDetailElement() {

      if (this.detailList == null) {
        this.detailList = []
      }

     this.detailList.push({ nombreItem:this.newDetailName, cantidad:this.newDetailQty, precio_unitario:this.newDetailAmount})
     this.newDetailName   = null
     this.newDetailQty    = 0
     this.newDetailAmount = 0

     this.dtInstance = {}

    }

    onDeleteDetailElement(index) {

      if (this.deleteList == null) {
        this.deleteList = []
      }

      if (typeof this.detailList[index]['id'] != 'undefined') {
        this.deleteList.push(this.detailList[index]['id'])
      }

      this.detailList.splice(index, 1)

    }

  }

export const InvoiceEditComponent = {
    templateUrl: './views/app/components/invoice-edit/invoice-edit.component.html',
    controller: InvoiceEditController,
    controllerAs: 'vm',
    bindings: {}
}
