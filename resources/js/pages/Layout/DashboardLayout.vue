<template>
  <div class="wrapper">
    <notifications></notifications>

    <side-bar>
      <mobile-menu slot="content"></mobile-menu>
      <sidebar-link to="/dashboard">
        <md-icon>dashboard</md-icon>
        <p
          style="color: white !important;font-family: 'Droid Arabic Naskh', serif;font-weight: regular;"
        >الرئيسية</p>
      </sidebar-link>
      <!--<sidebar-link to="/commandes">
        <md-icon>people</md-icon>
        <p
          style="color: white !important;font-family: 'Droid Arabic Naskh', serif;font-weight: regular;"
        >الطلبات</p>
      </sidebar-link>-->
      <sidebar-link to="/employes">
        <md-icon>people</md-icon>
        <p
          style="color: white !important;font-family: 'Droid Arabic Naskh', serif;font-weight: regular;"
        >المستخدمين</p>
      </sidebar-link>
      <sidebar-link to="/listeUsers" v-if="user.role === '1' || user.role === '2'">
        <md-icon>
          <i style="color: white !important;" class="fas fa-user-shield"></i>
        </md-icon>
        <p
          style="color: white !important;font-family: 'Droid Arabic Naskh', serif;font-weight: regular;"
        >المستعملين</p>
      </sidebar-link>
      <sidebar-link to="/listeClients">
        <md-icon>
          <i style="color: white !important;" class="fas fa-shopping-cart"></i>
        </md-icon>
        <p
          style="color: white !important;font-family: 'Droid Arabic Naskh', serif;font-weight: regular;"
        >الزبناء</p>
      </sidebar-link>

      <sidebar-link to="/fournisseur">
        <md-icon>
          <i style="color: white !important;" class="fas fa-globe"></i>
        </md-icon>
        <p
          style="color: white !important;font-family: 'Droid Arabic Naskh', serif;font-weight: regular;"
        >البائعون</p>
      </sidebar-link>

      <sidebar-link to="/listeSeries">
        <md-icon>
          <i style="color: white !important;" class="fas fa-shoe-prints"></i>
        </md-icon>
        <p
          style="color: white !important;font-family: 'Droid Arabic Naskh', serif;font-weight: regular;"
        >السيريات</p>
      </sidebar-link>
      <sidebar-link to="/entrees">
        <md-icon>
          <i style="color: white !important;" class="fas fa-money-bill-wave"></i>
        </md-icon>
        <p
          style="color: white !important;font-family: 'Droid Arabic Naskh', serif;font-weight: regular;"
        >الواردات</p>
      </sidebar-link>
      <sidebar-link to="/sorties">
        <md-icon>
          <i style="color: white !important;" class="fas fa-money-bill-wave"></i>
        </md-icon>
        <p
          style="color: white !important;font-family: 'Droid Arabic Naskh', serif;font-weight: regular;"
        >المبيعات</p>
      </sidebar-link>

      <sidebar-link to="/chargeHeader">
        <md-icon>
          <i style="color: white !important;" class="fas fa-dollar-sign"></i>
        </md-icon>
        <p
          style="color: white !important;font-family: 'Droid Arabic Naskh', serif;font-weight: regular;"
        >التكاليف</p>
      </sidebar-link>

      <!-- <sidebar-link to="/magasin" v-if="user.role === '1'">
        <md-icon><i  style="color: white !important;" class="fas fa-dollar-sign"></i></md-icon>
        <p style="color: white !important;font-family: 'Droid Arabic Naskh', serif;font-weight: regular;">المحلات</p>
      </sidebar-link>-->
    </side-bar>

    <div class="main-panel">
      <top-navbar></top-navbar>

      <dashboard-content></dashboard-content>

      <content-footer v-if="!$route.meta.hideFooter"></content-footer>
    </div>
  </div>
</template>
<style lang="scss">
</style>

<script>
import TopNavbar from "./TopNavbar.vue";
import ContentFooter from "./ContentFooter.vue";
import DashboardContent from "./Content.vue";
import MobileMenu from "@/pages/Layout/MobileMenu.vue";

export default {
  components: {
    TopNavbar,
    DashboardContent,
    ContentFooter,
    MobileMenu
  },
  data() {
    return {
      user: new Object()
    };
  },
  created() {
    const token = localStorage.getItem("token");
    fetch("/api/returnUser?token=" + token)
      .then(res => res.json())
      .then(res => {
        this.user = res.data;
      })
      .catch(err => console.log(err));
  }
};
</script>
