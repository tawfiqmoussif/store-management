<template>
  <div :key="salaireKey">
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"
    />
    <div class="content">
      <div class="md-layout">
        <div
          class="md-layout-item md-medium-size-100 md-xsmall-size-100 md-size-80"
          style="margin-right: 70px;"
        >
          <div class="md-layout">
            <div class="md-layout-item md-small-size-100 md-size-50">
              <md-button
                style="font-size: 16px;"
                class="md-success"
                type="button"
                data-toggle="modal"
                data-target="#exampleModal"
              >
                <md-icon class="fa fa-dollar-sign" />تسجيل دفعة
              </md-button>
            </div>
            <div class="md-layout-item md-small-size-100 md-size-50">
              <md-field>
                <md-input v-model.lazy="selectedDate" type="date"></md-input>
              </md-field>
            </div>

            <!-- Button trigger modal -->
          </div>
          <!-- Modal -->
          <div
            class="modal fade"
            id="exampleModal"
            tabindex="-1"
            role="dialog"
            aria-labelledby="exampleModalLabel"
            aria-hidden="true"
          >
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">المرجو إدخال المبلغ المدفوع للعامل</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <md-field>
                    <label>أدخل المبلغ</label>
                    <md-input type="number" v-model="employeT.sommesalaires"></md-input>
                  </md-field>
                </div>
                <div class="modal-footer">
                  <button
                    type="button"
                    data-dismiss="modal"
                    class="btn btn-success"
                    @click="updateSalaire()"
                    style="margin-top : -15px;border-color: #4caf50;background-color: #4caf50 !important;"
                  >حفظ</button>
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">خروج</button>
                </div>
              </div>
            </div>
          </div>
          <md-card>
            <md-card-header data-background-color="green">
              <h4>المبلغ المتبقي من الأجرة : {{employe.sommesalaires}} درهم</h4>
            </md-card-header>
            <md-card-content>
              <md-table v-model="avances" table-header-color="green">
                <md-table-row slot="md-table-row" slot-scope="{ item }">
                  <md-table-cell md-label="تاريخ تسليم المبلغ">{{ item.date }}</md-table-cell>
                  <md-table-cell md-label=" المبلغ المدفوع للعامل بالدرهم">{{ item.montant }} درهم</md-table-cell>
                </md-table-row>
              </md-table>
            </md-card-content>
          </md-card>
          <nav aria-label="Page navigation example">
            <ul class="pagination">
              <li v-bind:class="[{disabled: !pagination.prev_page_url}]" class="page-item">
                <a class="page-link" href="#" @click="fetchAvances(pagination.prev_page_url)">السابق</a>
              </li>

              <li class="page-item disabled">
                <a
                  class="page-link text-dark"
                  href="#"
                >{{ pagination.current_page }} من {{ pagination.last_page }}</a>
              </li>

              <li v-bind:class="[{disabled: !pagination.next_page_url}]" class="page-item">
                <a class="page-link" href="#" @click="fetchAvances(pagination.next_page_url)">التالي</a>
              </li>
            </ul>
          </nav>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "salaire",
  props: {
    tableHeaderColor: {
      type: String,
      default: ""
    }
  },
  data() {
    return {
      selectedDate: null,
      selected: [],
      avances: new Object(),
      employe: new Object(),
      employeT: {
        id: "",
        sommesalaires: ""
      },
      salaireKey: 0,
      pagination: {},
      AvanceEmploye: {
        montant: "",
        employe_id: "",
        date: ""
      },
      token : localStorage.getItem('token')
    };
  },
  watch: {
    selectedDate: function(value) {
      let send = {
        date: value,
        id: this.employe.id
      };
      fetch("/api/getByDate", {
        method: "post",
        body: JSON.stringify(send),
        headers: {
          "content-type": "application/json"
        }
      })
        .then(res => res.json())
        .then(res => {
          //affecter res.data a articles
          this.avances = res.data;
          console.log(this.avances);
        })
        .catch(err => console.log(err));
    }
  },
  created() {
    this.employe = this.$route.params.employe;
    this.fetchAvances();
  },
  methods: {
    onDateChange(date) {
      console.log(date);
    },
    forceRerender() {
      this.salaireKey += 1;
    },
    fetchAvances(page_url) {
      let vm = this;
      page_url = page_url || `/api/avanceEmployes/${this.employe.id}`;
      fetch(page_url)
        .then(res => res.json())
        .then(res => {
          this.avances = res.data;
          vm.makePagination(res.meta, res.links);
        })
        .catch(err => console.log(err));
    },
    makePagination(meta, links) {
      //create an object
      let pagination = {
        current_page: meta.current_page,
        last_page: meta.last_page,
        next_page_url: links.next,
        prev_page_url: links.prev
      };
      this.pagination = pagination;
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
    updateSalaire() {
      if (
        parseInt(this.employe.sommesalaires) >
        parseInt(this.employeT.sommesalaires)
      ) {
        this.employeT.id = this.employe.id;
        fetch(`api/updateSalaire`, {
          method: "post",
          body: JSON.stringify(this.employeT),
          headers: {
            "content-type": "application/json"
          }
        })
          .then(res => res.json())
          .then(data => {
            //add avance
            this.AvanceEmploye.montant = this.employeT.sommesalaires;
            this.AvanceEmploye.employe_id = this.employe.id;
            this.AvanceEmploye.date = this.formatDate(new Date());
            //mise a jour de la vue
            this.employe.sommesalaires = data.data.sommesalaires;
            this.employeT.sommesalaires = "";
            fetch("api/avanceEmploye?token="+this.token, {
              method: "post",
              body: JSON.stringify(this.AvanceEmploye),
              headers: {
                "content-type": "application/json"
              }
            })
              .then(res => res.json())
              .then(data => {
                this.fetchAvances();
                // this.forceRerender();
              })
              .catch(err => console.log(err));
          })
          .catch(err => console.log(err));
      } else {
        console.log("vous n avez pas le droit de faire ca");
      }
    }
  }
};
</script>

