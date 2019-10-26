<template>
  <div class="content">
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"
    />
    <div class="md-layout">
      <md-button v-if="userC.role === '1'" class="md-success md-just-icon md-round" to="/ajouterUser"> <md-icon>add</md-icon></md-button>
      <div class="md-layout-item md-medium-size-100 md-xsmall-size-100 md-size-100">
        <md-card>
          <md-card-header data-background-color="green">
            <h4 class="title">قائمة المستعملين</h4>
            <p class="category"></p>
          </md-card-header>
          <md-card-content>
            <md-table class="table-responsive" v-model="users" table-header-color="green">
              <md-table-row slot="md-table-row" slot-scope="{ item }">
                <md-table-cell md-label="الإسم">{{ item.personne.prenom }} {{ item.personne.nom }}</md-table-cell>
                <md-table-cell md-label="الهاتف">{{ item.personne.tel}}</md-table-cell>
                <md-table-cell md-label="العنوان">{{ item.personne.adresse }}</md-table-cell>
                <md-table-cell md-label="الإيميل">{{ item.email }}</md-table-cell>
                <md-table-cell md-label="إسم المحل">{{ item.magasin.nom }}</md-table-cell>
                <md-table-cell md-label="رقم الترخيص">{{ item.magasin.numero_de_patente }}</md-table-cell>
                <md-table-cell md-label="رقم البطاقة البنكية">{{ item.magasin.numero_compte_bancaire }}</md-table-cell>
                <md-table-cell md-label="ر.س">{{ item.magasin.rc }}</md-table-cell>
                <md-table-cell md-label="اختيار">
                  <!--<md-button v-if="userC.role === '1'"
                    :to="{name: 'modifierUser',params: {user: item}}"
                    class="md-warning md-just-icon md-round"
                  >
                    <md-icon>edit</md-icon>
                  </md-button>-->
                 <!-- <md-button v-if="userC.role === '1'"
                    @click="destroyUser(item.id, item.personne.id)"
                    class="md-danger md-just-icon md-round"
                  >
                    <md-icon>delete</md-icon>
                  </md-button>-->
                   <md-button v-if="userC.id != item.id"
                    :to="{name: 'stock',params: {user: item}}"
                    class="md-success md-just-icon md-round"
                  >
                    <md-icon>menu</md-icon>
                  </md-button>
                </md-table-cell>
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
  name: "liste-users",
  props: {
    tableHeaderColor: {
      type: String,
      default: ""
    }
  },
  data() {
    return {
      personne: {
        nom: "",
        prenom: "",
        tel: "",
        adresse: "",
        photo: "",
        photocopie_carte_national: ""
      },
      users: [],
      user: {
        name: "",
        email: "",
        personne_id: "",
        password: ""
      },
      sending: false,
      userC: new Object(),
    };
  },
  created() {
    const token = localStorage.getItem('token');
    fetch("/api/returnUser?token=" + token)
        .then(res => res.json())
        .then(res => {
          this.userC = res.data;
        })
        .catch(err => console.log(err));
    this.fetchUsers();
  },
  methods: {
    fetchUsers() {
      fetch("/api/users")
        .then(res => res.json())
        .then(res => {
          this.users = res.data;
        })
        .catch(err => console.log(err));
    },
    destroyUser(idUser, idPers) {
      if (confirm("Vous etes sur ?")) {
        fetch(`/api/user/${idUser}`, {
          method: "delete"
        })
          .then(res => res.json())
          .then(res => {
            alert("User removed");
            fetch(`/api/personne/${idPers}`, {
              method: "delete"
            })
              .then(res => res.json())
              .then(res => {
                alert("Personne removed");
                created();
              })
              .catch(err => console.log(err));
          })
          .catch(err => console.log(err));
      }
    }
  }
};
</script>