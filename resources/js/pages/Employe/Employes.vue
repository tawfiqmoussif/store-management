<template>
  <div class="content">
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"
    />
    <div class="md-layout">
      <div class="md-layout-item md-medium-size-100 md-xsmall-size-100 md-size-100">
        <md-button class="md-success md-just-icon md-round" to="/ajouterEmp">
          <md-icon>add</md-icon>
        </md-button>
        <md-card>
          <md-card-header data-background-color="green">
            <h4 class="title">قائمة المستخدمين</h4>
            <p class="category"></p>
          </md-card-header>
          <md-card-content>
            <md-table class="table-responsive" v-model="employes" table-header-color="green">
              <md-table-row slot="md-table-row" slot-scope="{ item }">
                <md-table-cell md-label="الاسم الشخصي">{{ item.personne.prenom }}</md-table-cell>
                <md-table-cell md-label="الاسم العائلي">{{ item.personne.nom }}</md-table-cell>
                <md-table-cell md-label="الهاتف">{{ item.personne.tel}}</md-table-cell>

                <md-table-cell md-label="العنوان">{{ item.personne.adresse }}</md-table-cell>

                <md-table-cell md-label="الأجرة">{{ item.salaire }}</md-table-cell>
                <md-table-cell md-label="تاريخ التشغيل">{{ item.date_recrutement }}</md-table-cell>
                <md-table-cell md-label="اختيار">
                  <!-- <md-button
                    :to="{name: 'profilEmp',params: {employe: item}}"
                    class="md-info md-just-icon md-round"
                  >
                    <md-icon>person</md-icon>
                  </md-button>-->
                  <md-button class="md-info md-just-icon md-round" @click="toProfil(item)">
                    <md-icon>person</md-icon>
                  </md-button>

                  <md-button @click="toCal(item)" class="md-success md-just-icon md-round">
                    <md-icon class="fa fa-calendar"></md-icon>
                  </md-button>
                  <md-button @click="toSal(item)" class="md-rose md-just-icon md-round">
                    <md-icon class="fa fa-dollar-sign"></md-icon>
                  </md-button>
                  <md-button
                    :to="{name: 'modifierEmp',params: {employe: item}}"
                    class="md-warning md-just-icon md-round"
                  >
                    <md-icon>edit</md-icon>
                  </md-button>
                 <md-button
                    @click="destroyEmploye(item.id, item.personne.id)"
                    class="md-danger md-just-icon md-round"
                  >
                    <md-icon>delete</md-icon>
                  </md-button>
                </md-table-cell>
              </md-table-row>
            </md-table>
          </md-card-content>
        </md-card>
        <mdb-modal :show="modal" v-if="show" @close="modal = false">
          <mdb-modal-body style="margin-top:0px;">
            <template>
              <div class="content">
                <div class="md-layout">
                  <div
                    class="md-layout-item md-medium-size-100 md-size-100"
                  >
                    <md-card class="md-card-profile">
                      <div class="md-card-avatar">
                        <img class="img" :src="photo_url" />
                      </div>

                      <md-card-content>
                        <div class="md-layout">
                          <div class="md-layout-item md-small-size-100 md-size-100">
                            <div>
                              <label
                                class="md-title"
                                style="color: black !important;"
                              >{{employe.personne.prenom}} {{employe.personne.nom}}</label>
                            </div>

                            <div>
                              <label
                                class="md-title"
                                style="color: black !important;"
                              >رقم الهاتف : {{employe.personne.tel}}</label>
                            </div>

                            <div class="md-layout-item md-small-size-100 md-size-100">
                              <label
                                class="md-title"
                                style="color: black !important;"
                              >العنوان: {{employe.personne.adresse}}</label>
                            </div>
                            <div class="md-layout-item md-small-size-100 md-size-100">
                              <label
                                class="md-title"
                                style="color: black !important;"
                              >تاريخ بداية العمل : {{employe.date_recrutement}}</label>
                            </div>
                            <div class="md-layout-item md-small-size-100 md-size-100">
                              <label
                                class="md-title"
                                style="color: black !important;"
                              >الأجرة اليومية: {{employe.salaire}} درهم</label>
                            </div>
                            <md-card-media md-big>
                              <img :src="photocopie_url" style=" height: 15rem; width: 30rem;" />
                            </md-card-media>
                          </div>
                        </div>
                      </md-card-content>
                    </md-card>
                  </div>
                </div>
              </div>
            </template>
          </mdb-modal-body>
        </mdb-modal>
      </div>
    </div>
  </div>
</template>
               

<script>
import {
  mdbModal,
  mdbModalHeader,
  mdbModalTitle,
  mdbModalBody,
  mdbModalFooter,
  mdbBtn
} from "mdbvue";

export default {
  name: "liste-employes",
  props: {
    tableHeaderColor: {
      type: String,
      default: ""
    }
  },
  components: {
    mdbModal,
    mdbModalHeader,
    mdbModalTitle,
    mdbModalBody,
    mdbModalFooter,
    mdbBtn
  },
  data() {
    return {
      show:false,
      modal: false,
      photo_url: "/photos/NoImage.png",
      photocopie_url: "/photos/NoImage.png",
      employe: new Object(),
      personne: {
        nom: "",
        prenom: "",
        tel: "",
        adresse: "",
        photo: "",
        photocopie_carte_national: ""
      },
      employes: [],
      employe: {
        date_recrutement: null,
        salaire: "",
        personne_id: "",
        magasin_id: ""
      },
      active: false,
      value: null
    };
  },
  created() {
    this.fetchEmployes();
  },
  methods: {
    toSal(employe) {
      this.$router.push({ name: "salaire", params: { employe } });
    },
    toCal(employe) {
      this.$router.push({ name: "calendrier", params: { employe } });
    },
    toProfil(employe) {
      
      this.employe = employe;
      if (this.employe.personne.photo) {
        this.photo_url = "/photos/" + this.employe.personne.photo;
      }
      if (this.employe.personne.photocopie_carte_national) {
        this.photocopie_url =
          "/photoCopieCarteNational/" +
          this.employe.personne.photocopie_carte_national;
      }
      this.show = true;
      this.modal= true;
    },
    fetchEmployes() {
      const token = localStorage.getItem("token");

      fetch("/api/employes?token=" + token)
        .then(res => res.json())
        .then(res => {
          //affecter res.data a articles
          this.employes = res.data;
        })
        .catch(err => console.log(err));
    },
    destroyEmploye(idEmp, idPers) {
      if (confirm("Vous etes sur ?")) {
        fetch(`/api/employe/${idEmp}`, {
          method: "delete"
        })
          .then(res => res.json())
          .then(res => {
            alert("Employe removed");
            fetch(`/api/personne/${idPers}`, {
              method: "delete"
            })
              .then(res => res.json())
              .then(res => {
                alert("Personne removed");
                this.fetchEmployes();
              })
              .catch(err => console.log(err));
          })
          .catch(err => console.log(err));
      }
    }
  }
};
</script>