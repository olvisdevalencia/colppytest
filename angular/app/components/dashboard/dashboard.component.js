class DashboardController {

  constructor(APIinvoice, DTOptionsBuilder, DTColumnDefBuilder, $state) {
      'ngInject';

      this.APIinvoice            = APIinvoice;
      this.$state                = $state
      this.invoicesList          = true
      this.invoiceCreation       = false
      this.invoiceDetail         = false
      this.dtColumns             = {}
      this.enterprises           = null
      this.clients               = null
      this.detailList            = null
      this.invoiceList           = null
      this.selectedEnterprise    = null
      this.selectedClient        = null

      this.dtColumnDefs         = [DTColumnDefBuilder.newColumnDef(2).notSortable()];
      this.dtOptions            = DTOptionsBuilder.newOptions()
                                                  .withOption('paging', true)
                                                  .withOption('searching', true)
                                                  .withOption('info', true)
                                                  .withOption('responsive', true)
                                                  .withOption('FixedHeader', true)
                                                  .withOption('order', [[0, 'desc']])
                                                  .withBootstrap();

      this.APIinvoice.all('invoices/list').post().then(
        (res) => {

           this.invoiceList           = res

       })

    }

    $onInit() {

    }

    OnCreateInvoice() {

      this.invoicesList      = false
      this.invoiceCreation   = true

      this.APIinvoice.all('enterprises/list').post().then(
        (res) => {
          this.enterprises  = res
       })

    }

    OnSelectedEnterprise() {

      if (typeof this.selectedEnterprise != 'undefined') {

        let data = {
               idEmpresa    : this.selectedEnterprise.id
        }

        this.APIinvoice.all('clients/list').post(data).then(
          (res) => {
            this.clients  = res
         })

      } else {

        this.clients = null
      }
    }

    onCancel() {

      this.invoicesList       = true
      this.invoiceCreation    = false
      this.invoiceDetail      = false
      this.enterprises        = null
      this.clients            = null
      this.selectedEnterprise = null
      this.selectedClient     = null
      this.detailList         = null
      this.newDetailName      = null
      this.newDetailQty       = 0
      this.newDetailAmount    = 0
    }

    onNext() {

      this.invoicesList       = false
      this.invoiceCreation    = false
      this.invoiceDetail      = true
    }

    onCreate() {

      var vm          = this
      let $state      = this.$state
      swal({
        title: 'Quieres crear la factura ?',
        text: 'Al presionar el boton Continuar se procesara la factura',
        type: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Continuar',
        cancelButtonText: 'No, cancelar!',
        closeOnConfirm: false,
        closeOnCancel: false
      }, (isConfirm) => {

        if (isConfirm) {

          let data = {
                 detailList     : vm.detailList,
                 idEmpresa      : vm.selectedEnterprise.id,
                 idCliente      : vm.selectedClient.id
          }

          this.APIinvoice.all('invoices/create').post(data).then(
            (res) => {
              console.log(res)
           })
          swal('Procesado!', 'La factura ha sido cargada con exito.', 'success')

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

     this.detailList.push({ name:this.newDetailName, qty:this.newDetailQty, amount:this.newDetailAmount})
     this.newDetailName   = null
     this.newDetailQty    = 0
     this.newDetailAmount = 0

     this.dtInstance = {};

    }

    onDeleteDetailElement(index) {

      this.detailList.splice(index, 1);

    }

  }

  export const DashboardComponent = {
  templateUrl: './views/app/components/dashboard/dashboard.component.html',
  controller: DashboardController,
  controllerAs: 'vm',
  bindings: {}
  }
