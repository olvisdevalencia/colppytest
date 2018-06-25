export function RoutesConfig ($stateProvider, $urlRouterProvider) {
  'ngInject'

  var getView = (viewName) => {
    return `./views/app/pages/${viewName}/${viewName}.page.html`
  }

  var getLayout = (layout) => {
    return `./views/app/pages/layout/${layout}.page.html`
  }

  $urlRouterProvider.otherwise('/')

  $stateProvider
    .state('app', {
      abstract: true,
      views: {
        'layout': {
          templateUrl: getLayout('layout')
        },
        'header@app': {
          templateUrl: getView('header')
        },
        'footer@app': {
          templateUrl: getView('footer')
        },
        main: {}
      },
      data: {
        bodyClass: 'hold-transition skin-blue sidebar-mini'
      }
    })
    .state('app.landing', {
      url: '/',
      data: {
        auth: true
      },
      views: {
        'main@app': {
          templateUrl: getView('landing')
        }
      }
    })
    .state('app.invoiceview', {
      url: '/invoice-view/:invoiceId',
      data: {
        auth: true
      },
      views: {
        'main@app': {
          template: '<invoice-view></invoice-view>'
        }
      },
      params: {
        alerts: null,
        invoiceId: null
      }
    })
    .state('app.invoiceedit', {
      url: '/invoice-edit/:invoiceId',
      data: {
        auth: true
      },
      views: {
        'main@app': {
          template: '<invoice-edit></invoice-edit>'
        }
      },
      params: {
        alerts: null,
        invoiceId: null
      }
    })
    .state('app.testquestion', {
      url: '/test-questions',
      data: {
        auth: true
      },
      views: {
        'main@app': {
          templateUrl: getView('testquestions')
        }
      }
    })
    .state('app.profile', {
      url: '/profile',
      data: {
        auth: true
      },
      views: {
        'main@app': {
          template: '<user-profile></user-profile>'
        }
      },
      params: {
        alerts: null
      }
    })
    .state('login', {
      url: '/login',
      views: {
        'layout': {
          templateUrl: getView('login')
        },
        'header@app': {},
        'footer@app': {}
      },
      data: {
        bodyClass: 'hold-transition login-page'
      },
      params: {
        registerSuccess: null,
        successMsg: null
      }
    })
    .state('loginloader', {
      url: '/login-loader',
      views: {
        'layout': {
          templateUrl: getView('login-loader')
        },
        'header@app': {},
        'footer@app': {}
      },
      data: {
        bodyClass: 'hold-transition login-page'
      }
    })
    .state('app.logout', {
      url: '/logout',
      views: {
        'main@app': {
          controller: function ($rootScope, $scope, $auth, $state, AclService) {
            $auth.logout().then(function () {
              delete $rootScope.me
              AclService.flushRoles()
              AclService.setAbilities({})
              $state.go('login')
            })
          }
        }
      }
    })
}
