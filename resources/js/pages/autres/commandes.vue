<template>
  <div class="content">
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"
    />
    <div class="md-layout">
      <!--<md-button v-if="userC.role === '1'" class="md-success md-just-icon md-round" to="/ajouterUser"> <md-icon>add</md-icon></md-button>
      --><div class="md-layout-item md-medium-size-100 md-xsmall-size-100 md-size-100">
        <md-card>
          <md-card-header data-background-color="green">
            <h4 class="title">قائمة المستعملين</h4>
            <p class="category"></p>
          </md-card-header>
          <md-card-content>
            <md-table class="table-responsive" v-model="commandes" table-header-color="green">
              <md-table-row slot="md-table-row" slot-scope="{ item }">
                <md-table-cell md-label="صاحب المحل">{{item.fournisseurO.personne.nom}} {{item.fournisseurO.personne.prenom}}</md-table-cell>
                <md-table-cell md-label="نوع البضاعة">{{ item.article.serie.ref}}</md-table-cell>
                <md-table-cell md-label="المورد">{{ item.article.serie.personne.nom }}{{ item.article.serie.personne.prenom }}</md-table-cell>
                <md-table-cell md-label="اللون">{{ item.article.serie.couleur }}</md-table-cell>
                <md-table-cell md-label="رقم الحذاء">{{ item.article.taille }}</md-table-cell>
                <md-table-cell md-label="الكمية">{{ item.qte }}</md-table-cell>
                <md-table-cell md-label="التاريخ">{{ item.date }}</md-table-cell>
                <md-table-cell md-label="الحالة">{{ item.etat }}</md-table-cell>
              </md-table-row>
            </md-table>
          </md-card-content>
        </md-card>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "commandes",
  props: {
    tableHeaderColor: {
      type: String,
      default: ""
    }
  },
  data() {
    return {
        commandes: [],
        token: localStorage.getItem("token"),
    };
  },
  created() {
   this.fetchCommandes();
  },
  methods: {
    fetchCommandes() {
      fetch("/api/commandes?token=" + this.token)
        .then(res => res.json())
        .then(res => {
          this.commandes = res.data;
        })
        .catch(err => console.log(err));
    }
  }
};
</script>