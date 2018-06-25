import { RouteBodyClassComponent } from './directives/route-bodyclass/route-bodyclass.component'
import { PasswordVerifyClassComponent } from './directives/password-verify/password-verify.component'
import { AllowDecimalNumbersClassComponent } from './directives/allow-decimal-numbers/allow-decimal-numbers.component'

angular.module('app.components')
  .directive('routeBodyclass', RouteBodyClassComponent)
  .directive('passwordVerify', PasswordVerifyClassComponent)
  .directive('allowDecimalNumbers', AllowDecimalNumbersClassComponent)
