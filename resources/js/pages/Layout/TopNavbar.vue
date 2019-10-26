<template>
  <div>
    <md-toolbar md-elevation="0" class="md-transparent">
      <div class="md-toolbar-row">
        <!--<div class="md-toolbar-section-start">
          <h3 class="md-title">{{$route.name}}</h3>
        </div>-->
        <div class="md-toolbar-section-end">
          <md-button
            class="md-just-icon md-simple md-toolbar-toggle"
            :class="{toggled: $sidebar.showSidebar}"
            @click="toggleSidebar"
          >
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </md-button>

          <div class="md-collapse">
            <!--<div class="md-autocomplete">
            <md-autocomplete class="search" v-model="selectedEmployee" :md-options="employees">
              <label>Search...</label>
            </md-autocomplete>
            </div>-->
            <md-list>
              <md-list-item to="/calendar">
                <i class="material-icons fas fa-calendar-alt"></i>
                <p class="hidden-lg hidden-md">Dashboard</p>
              </md-list-item>
              <md-list-item @click="toNotif()">
                <a>
                  <i class="material-icons">notifications</i>
                  <span
                    style="margin-top:-8px;"
                    class="notification"
                    v-if="(avancesEntree.length+avancesSortie.length+commandes_acceptees.length+commandes_en_attente.length)>0 && count==0"
                  >{{avancesEntree.length + avancesSortie.length + commandes_acceptees.length + commandes_en_attente.length}}</span>
                  <p class="hidden-lg hidden-md">Notifications</p>
                </a>
              </md-list-item>
              <md-list-item to="/dashboard">
                <i class="material-icons">dashboard</i>
                <p class="hidden-lg hidden-md">Dashboard</p>
              </md-list-item>
              <md-list-item>
                <md-menu>
                  <md-icon class="material-icons" md-menu-trigger>person</md-icon>

                  <md-menu-content>
                    <md-menu-item>
                      <!--<md-icon>phone</md-icon>-->
                      <a @click="lancerModal">تغيير كلمة المرور</a>
                    </md-menu-item>
                    <md-menu-item>
                      <!--<md-icon>phone</md-icon>-->
                      <a @click="exit">تسجيل الخروج</a>
                    </md-menu-item>
                  </md-menu-content>
                </md-menu>
              </md-list-item>
              <!-- <md-list-item to="/notif">
              <a>
                <i class="material-icons">notifications</i>
                <span style="margin-top:-8px;background-color:green;" class="notification">{{avancesEntree.length}}</span>
                <p class="hidden-lg hidden-md">Notifications</p>
              </a>
              </md-list-item>-->

              <!--<md-list-item to="/notif" class="dropdown">
              <drop-down>
                <a slot="title" class="dropdown-toggle" data-toggle="dropdown">
                  <i class="material-icons">notifications</i>
                  <span class="notification">{{avancesEntree.length}}</span>
                  <p class="hidden-lg hidden-md">Notifications</p>
                </a>
                <ul class="dropdown-menu dropdown-menu-right" >
                  <li><a href="#">Mike John responded to your email</a></li>
                  <li><a href="#">You have 5 new tasks</a></li>
                </ul>
              </drop-down>
              </md-list-item>-->

              <!--<md-list-item to="/user">
              <i class="material-icons">person</i>
              <p class="hidden-lg hidden-md">Profile</p>
              </md-list-item>-->
            </md-list>
          </div>
        </div>
      </div>
    </md-toolbar>
    <mdb-modal :show="modal" @close="modal = false">
      <mdb-modal-header>
        <mdb-modal-title></mdb-modal-title>
      </mdb-modal-header>
      <mdb-modal-body>
        <input
          type="password"
          placeholder="كلمة المرور الحالية"
          v-model="pssw"
          class="form-control mb-4"
        />
        <input type="password" placeholder="كلمة المرور" v-model="pssw1" class="form-control mb-4" />
        <input
          type="password"
          placeholder="تأكيد كلمة المرور"
          v-model="pssw2"
          class="form-control mb-4"
        />
      </mdb-modal-body>
      <mdb-modal-footer>
        <mdb-btn color="primary" style="margin :10px;" @click="changePassword()">حفظ</mdb-btn>
        <mdb-btn color="secondary" style="margin :10px;" @click.native="modal = false">إغلاق</mdb-btn>
      </mdb-modal-footer>
    </mdb-modal>
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
      selectedEmployee: null,
      employees: [
        "Jim Halpert",
        "Dwight Schrute",
        "Michael Scott",
        "Pam Beesly",
        "Angela Martin",
        "Kelly Kapoor",
        "Ryan Howard",
        "Kevin Malone"
      ],
      avancesSortie: [],
      avancesEntree: [],
      token: localStorage.getItem("token"),
      count: 0,
      modal: false,
      pssw: "",
      pssw1: "",
      pssw2: "",
      commandes_en_attente: [],
      commandes_acceptees: []
    };
  },

  created() {
    let date = { date: this.formatDate(new Date()) };
    this.commandes_en_attenteF();
    this.commandes_accepteesF();
    fetch("api/avancesEntreeNotif?token=" + this.token, {
      method: "post",
      body: JSON.stringify(date),
      headers: {
        "content-type": "application/json"
      }
    })
      .then(res => res.json())
      .then(data => {
        this.avancesEntree = data.data;
      })
      .catch(err => console.log(err));
    fetch("api/avancesSortieNotif?token=" + this.token, {
      method: "post",
      body: JSON.stringify(date),
      headers: {
        "content-type": "application/json"
      }
    })
      .then(res => res.json())
      .then(data => {
        this.avancesSortie = data.data;
      })
      .catch(err => console.log(err));
  },
  methods: {
    exit() {
       localStorage.removeItem('token');
       this.$router.push({ path: "/" });
     
    },
    commandes_en_attenteF() {
      fetch("/api/commandes_en_attente?token=" + this.token)
        .then(res => res.json())
        .then(res => {
          this.commandes_en_attente = res.data;
        })
        .catch(err => console.log(err));
    },
    commandes_accepteesF() {
      fetch("/api/commandes_acceptees?token=" + this.token)
        .then(res => res.json())
        .then(res => {
          this.commandes_acceptees = res.data;
        })
        .catch(err => console.log(err));
    },
    lancerModal() {
      this.modal = true;
    },
    changePassword() {
      fetch("api/checkPassword?token=" + this.token, {
        method: "post",
        body: JSON.stringify({ password: this.pssw }),
        headers: {
          "content-type": "application/json"
        }
      })
        .then(res => res.json())
        .then(data => {
          if (data == 1) {
            if (this.pssw1 != this.pssw2) {
              this.$notification.error("كلمتا المرور غير متطابقتين", {
                timer: 10
              });
            } else {
              fetch("api/changePassword?token=" + this.token, {
                method: "put",
                body: JSON.stringify({ password: this.pssw1 }),
                headers: {
                  "content-type": "application/json"
                }
              })
                .then(res => res.json())
                .then(data => {
                  this.modal = false;
                  this.$notification.success(
                    "   لقد تم تغيير كلمة المرور بنجاح  ",
                    {
                      timer: 10
                    }
                  );
                })
                .catch(err => console.log(err));
            }
            
          }
          else{
             this.$notification.error(
                    "كلمة المرور خاطئة حاول مرة أخرى",
                    {
                      timer: 10
                    }
                  );
          }
        })
        .catch(err => console.log(err));
    },
    formatDate(date1) {
      return (
        date1.getFullYear() +
        "-" +
        (date1.getMonth() < 9 ? "0" : "") +
        (date1.getMonth() + 1) +
        "-" +
        (date1.getDate() < 10 ? "0" : "") +
        date1.getDate()
      );
    },
    toNotif() {
      let avances = {
        avancesEntree: this.avancesEntree,
        avancesSortie: this.avancesSortie
      };
      this.count++;
      this.$router.push({ name: "Notif", params: { avances } });
    },
    toggleSidebar() {
      this.$sidebar.displaySidebar(!this.$sidebar.showSidebar);
    }
  }
};
</script>


<style lang="css">
</style>
