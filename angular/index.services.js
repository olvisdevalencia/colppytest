import { ContextService } from './services/context.service'
import { APIService } from './services/API.service'
import { APIinvoiceService } from './services/APIinvoice.service'

angular.module('app.services')
  .service('ContextService', ContextService)
  .service('API', APIService)
	.service('APIinvoice', APIinvoiceService)
