import {TestQuestionsComponent} from './app/components/test-questions/test-questions.component';
import {InvoiceEditComponent} from './app/components/invoice-edit/invoice-edit.component';
import {InvoiceViewComponent} from './app/components/invoice-view/invoice-view.component';
import { UserProfileComponent } from './app/components/user-profile/user-profile.component'
import { DashboardComponent } from './app/components/dashboard/dashboard.component'
import { NavSidebarComponent } from './app/components/nav-sidebar/nav-sidebar.component'
import { NavHeaderComponent } from './app/components/nav-header/nav-header.component'
import { LoginLoaderComponent } from './app/components/login-loader/login-loader.component'
import { LoginFormComponent } from './app/components/login-form/login-form.component'

angular.module('app.components')
	.component('testQuestions', TestQuestionsComponent)
	.component('invoiceEdit', InvoiceEditComponent)
	.component('invoiceView', InvoiceViewComponent)
  .component('userProfile', UserProfileComponent)
  .component('dashboard', DashboardComponent)
  .component('navSidebar', NavSidebarComponent)
  .component('navHeader', NavHeaderComponent)
  .component('loginLoader', LoginLoaderComponent)
  .component('loginForm', LoginFormComponent)
