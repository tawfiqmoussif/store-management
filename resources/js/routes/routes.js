import DashboardLayout from '@/pages/Layout/DashboardLayout.vue'

import Dashboard from '@/pages/Dashboard.vue'
import UserProfile from '@/pages/UserProfile.vue'
import TableList from '@/pages/TableList.vue'
import Typography from '@/pages/Typography.vue'
import Icons from '@/pages/Icons.vue'
import Maps from '@/pages/Maps.vue'
import Notifications from '@/pages/Notifications.vue'
import Notif from '@/pages/notif.vue'
//charges
import ModifierCharge from '@/pages/Charge/ModifierCharge.vue'
import AjouterCharge from '@/pages/Charge/AjouterCharge.vue'
import ChargeHeader from '@/pages/Charge/ChargeHeader.vue'
//Employes
import Employes from '@/pages/Employe/Employes.vue'
import Calendrier from '@/pages/Employe/Calendrier.vue'
import Salaire from '@/pages/Employe/Salaire.vue'
import AjouterEmploye from '@/pages/Employe/Ajouter.vue'
import ProfileEmploye from '@/pages/Employe/Profil.vue'
import ModifierEmploye from '@/pages/Employe/Modifier.vue'
//Fournisseurs
import Modifier from '@/pages/Fournisseurs/Modifier.vue'
import AjouterFournisseur from '@/pages/Fournisseurs/AjouterFournisseur.vue'
import Fournisseur from '@/pages/Fournisseurs/Fournisseurs.vue'
//Entrees
import Entrees from '@/pages/Entree/Entrees.vue'
import AjouterEntree from '@/pages/Entree/Ajouter.vue'
import Test from '@/pages/Employe/Test.vue'
import Form from '@/pages/Employe/form.vue'
//Sorties
import Sorties from '@/pages/Sorties/Sorties.vue'
import AjouterSortie from '@/pages/Sorties/Ajouter.vue'
//Clients
import ListeClients from '@/pages/Client/ListeClients.vue'
import AjouterClient from '@/pages/Client/AjouterClient.vue'
import ModifierClient from '@/pages/Client/ModifierClient.vue'
//Users
import ListeUsers from '@/pages/User/ListeUsers.vue'
import AjouterUser from '@/pages/User/AjouterUser.vue'
import ModifierUser from '@/pages/User/ModifierUser.vue'
//Series
import ListeSeries from '@/pages/Serie/ListeSeries.vue'
import AjouterSerie from '@/pages/Serie/AjouterSerie.vue'
import ModifierSerie from '@/pages/Serie/ModifierSerie.vue'
import Articles from '@/pages/Serie/Articles.vue'
//Magasin
import Magasin from '@/pages/Magasin/Ajoutermagasin.vue'


import SignIn from "@/pages/App.vue"
import Test2 from '@/pages/Employe/Test2.vue'

//autres
import Calendar from '@/pages/autres/calendar.vue'
import Stock from '@/pages/autres/stock.vue'
import Commandes from '@/pages/autres/commandes.vue'
const routes = [
  {
    path: '/',
    component: SignIn,
    redirect: 'login',
    children: [
      {
        path: 'login',
        name: 'login',
        component: SignIn
      }

    ]

  },
  {
    path: '/',
    component: DashboardLayout,
    redirect: '/dashboard',
    children: [
      {
        path: 'dashboard',
        name: 'Dashboard',
        component: Dashboard
      },
      {
        path: 'test',
        name: 'Test',
        component: Test
      },
      {
        path: 'calendar',
        name: 'calendar',
        component: Calendar
      },
      {
        path: 'commandes',
        name: 'commandes',
        component: Commandes
      },
      {
        path: 'stock/:user',
        name: 'stock',
        component: Stock
      },
      //les employes
      {
        path: 'ajouterEmp',
        name: 'ajouterEmp',
        component: AjouterEmploye
      },
      {
        path: 'employes',
        name: 'employes',
        component: Employes
      },
      {
        path: 'profilEmp/:employe',
        name: 'profilEmp',
        component: ProfileEmploye
      },
      {
        path: 'salaire/:employe',
        name: 'salaire',
        component: Salaire
      },
      {
        path: 'calendrier/:employe',
        name: 'calendrier',
        component: Calendrier
      },
      {
        path: 'modifierEmp/:employe',
        name: 'modifierEmp',
        component: ModifierEmploye
      },
      //////////////////////////////////////////////
      //les fournisseurs
      {
        path: 'modifierFour',
        name: 'modifierFour',
        component: Modifier
      },
      {
        path: 'Add',
        name: 'AddFour',
        component: AjouterFournisseur
      },
      {
        path: 'fournisseur',
        name: 'fournisseur',
        component: Fournisseur
      },
      {
        path: 'ajouterFour',
        name: 'ajouterFour',
        component: AjouterFournisseur
      },
      ///////////////////////////////////////////////
      //le charges
      {
        path: 'ajouterCharge',
        name: 'Ajouter Charge',
        component: AjouterCharge
      },
      {
        path: 'modifCharge/:charge',
        name: 'Modifier Charge',
        component: ModifierCharge
      },
      {
        path: 'chargeHeader',
        name: 'ChargeHeader',
        component: ChargeHeader
      },
       //////////////////
      //Magasins
      {
        path: 'magasin',
        name: 'magasin',
        component: Magasin
      },
      ////////////////////////////////////////////////////
      ///////////////////////////////////////////////
      //les entrees
      {
        path: 'entrees',
        name: 'entrees',
        component: Entrees
      },
      {
        path: 'ajouterEntree/:object',
        name: 'ajouterEntree',
        component: AjouterEntree
      },
      ///////////////////////////////////////////////
      //les sorties
      {
        path: 'sorties',
        name: 'sorties',
        component: Sorties
      },
      {
        path: 'ajouterSortie/:object',
        name: 'ajouterSortie',
        component: AjouterSortie
      },
      ////////////////////////////////////////////////////
      ///// Les clients
      {
        path: 'ajouterClient',
        name: 'AjouterClient',
        component: AjouterClient
      },
      {
        path: 'modifierClient/:client',
        name: 'modifierClient',
        component: ModifierClient
      },
      {
        path: 'listeClients',
        name: 'ListeClients',
        component: ListeClients
      },
      ////////////////////////////////////////////////////
      ///// Les users
      {
        path: 'ajouterUser',
        name: 'AjouterUser',
        component: AjouterUser
      },
      {
        path: 'listeUsers',
        name: 'ListeUsers',
        component: ListeUsers
      },
      {
        path: 'modifierUser/:user',
        name: 'modifierUser',
        component: ModifierUser
      },
      ////////////////////////////////////////////////////
      /////// Les Series
      {
        path: 'listeSeries',
        name: 'ListeSeries',
        component: ListeSeries
      },
      {
        path: 'modifierSerie/:serie',
        name: 'ModifierSerie',
        component: ModifierSerie
      },
      {
        path: 'ajouterSerie',
        name: 'AjouterSerie',
        component: AjouterSerie
      },
      {
        path: 'articles/:serie',
        name: 'articles',
        component: Articles
      },
      ///////////////////////////////////////////////////

      {
        path: 'user',
        name: 'User Profile',
        component: UserProfile
      },
      {
        path: 'table',
        name: 'Table List',
        component: TableList
      },
      {
        path: 'typography',
        name: 'Typography',
        component: Typography
      },
      {
        path: 'icons',
        name: 'Icons',
        component: Icons
      },
      {
        path: 'maps',
        name: 'Maps',
        meta: {
          hideFooter: true
        },
        component: Maps

      },
      {
        path: 'notif/:avances',
        name: 'Notif',
        component: Notif
      },
      {
        path: 'notifications',
        name: 'Notifications',
        component: Notifications
      },
      {
        path: 'demo',
        name: 'demo',
        component: Form
      },
      {
        path: 'data',
        name: 'data',
        component: Test2
      }
    ]
  }
]

export default routes
function newFunction() {
  return 'modifierEmp';
}

