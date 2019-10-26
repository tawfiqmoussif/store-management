<template>
  <div class="content">
    <div class="md-layout">
      <md-button class="md-success md-just-icon md-round" to="/ajouterCharge">
        <md-icon>add</md-icon>
      </md-button>
      <!-- code Added -->
      <div class="md-layout-item md-small-size-100 md-size-30">
        <md-field>
          <label>نوع التكليف</label>
          <md-input v-model="libele"></md-input>
        </md-field>
      </div>

      <div class="md-layout-item md-small-size-100 md-size-30">
        <md-field>
          <label>المبلغ الإجمالي</label>
          <md-input v-model="montant_Charge"></md-input>
        </md-field>
      </div>

      <div class="md-layout-item md-small-size-100 md-size-30">
        <md-field>
          <label>التاريخ</label>
          <md-input v-model="date_Charge" type="date"></md-input>
        </md-field>
      </div>
      <!--  -->

      <div class="md-layout-item md-medium-size-100 md-xsmall-size-100 md-size-100">
        <md-card>
          <md-card-header data-background-color="green">
            <h4 class="title">قائمة التكاليف</h4>
            <p class="category"></p>
          </md-card-header>
          <md-card-content>
            <md-table
              class="table-responsive"
              v-model="paginedCharges"
              :table-header-color="tableHeaderColor"
            >
              <md-table-row slot="md-table-row" slot-scope="{ item }">
                <md-table-cell md-label="نوع التكليف">{{ item.typeCharge.libele}}</md-table-cell>
                <md-table-cell md-label="المبلغ الإجمالي">{{ item.montant_total}}</md-table-cell>
                <md-table-cell md-label="التاريخ">{{ item.date}}</md-table-cell>
                <md-table-cell md-label="اختيار">
                  <md-button
                    :to="{name: 'Modifier Charge',params: {charge: item}}"
                    class="md-warning md-just-icon md-round"
                  >
                    <md-icon>edit</md-icon>
                  </md-button>

                  <md-button
                    @click="destroyCharge(item.id)"
                    class="md-danger md-just-icon md-round"
                  >
                    <md-icon>delete</md-icon>
                  </md-button>
                </md-table-cell>
              </md-table-row>
            </md-table>
          </md-card-content>

          <!-- setPage is our method defined in methods object -->
        </md-card>
        <div
          class="md-layout-item md-small-size-100 md-size-40"
          style="margin : 0 auto;display: flex;justify-content: center;"
        >
         
          <mdb-btn style="border-color: #4caf50;background-color: #4caf50 !important;" color="success" :disabled="page === 0" @click="prec()"> <i class="fas fa-forward"></i>
            السابق
          </mdb-btn>
        <p style="margin-top: 20px;" v-if="this.filtredCharge.length>0"> {{ page + 1 }} من {{ Math.ceil(this.filtredCharge.length/this.itemsPerPage) }}</p>
         
           <mdb-btn
            style="border-color: #4caf50;background-color: #4caf50 !important;"
            color="success"
            :disabled="page === Math.ceil(this.filtredCharge.length/this.itemsPerPage)-1 || this.filtredCharge.length==0"
            @click="suiv()"
          >
            التالي <i class="fas fa-backward"></i>
          </mdb-btn>
        </div>
        
      </div>
    </div>
  </div>
</template>

<script>
import { mdbBtn, mdbIcon } from "mdbvue";
export default {
  name: "liste-charges",
  props: {
    tableHeaderColor: {
      type: String,
      default: ""
    }
  },
  data() {
    return {
      libele: "",
      montant_Charge: "",
      date_Charge: "",
      charges: [],
      charge: {
        type_charge_id: "",
        montant_total: "",
        date: null
      },
      token: localStorage.getItem("token"),
      page: 0,
      itemsPerPage: 2
    };
  },
  created() {
    this.fetchCharges();
  },
  components: {
    mdbBtn,
    mdbIcon
  },
  methods: {
    suiv() {
      this.page = this.page + 1;
    },
    prec() {
      this.page = this.page - 1;
    },
    fetchCharges() {
      fetch("/api/charges?token=" + this.token)
        .then(res => res.json())
        .then(res => {
          this.charges = res.data;
        })
        .catch(err => console.log(err));
    },
    destroyCharge(idCharge) {
      if (confirm("Vous etes sur ?")) {
        fetch(`/api/charge/${idCharge}`, {
          method: "delete"
        })
          .then(res => res.json())
          .then(res => {})
          .catch(err => console.log(err));
      }
    },
    paginate() {
      return this.filtredCharge.slice(
        this.page * this.itemsPerPage,
        this.itemsPerPage * this.page + this.itemsPerPage
      );
    }
  },
  computed: {
    numPages() {
      return Math.ceil(this.filtredCharge.length / this.itemsPerPage);
    },
    filtredCharge: function() {
      let currentObject = this;
      return this.charges.filter(function(item) {
        return (
          item.typeCharge.libele.includes(currentObject.libele) &&
          item.montant_total
            .toString()
            .includes(currentObject.montant_Charge.toString()) &&
          item.date.toString().includes(currentObject.date_Charge.toString())
        );
      });
    },
    paginedCharges() {
      return this.filtredCharge.slice(
        this.page * this.itemsPerPage,
        this.itemsPerPage * this.page + this.itemsPerPage
      );
    }
  }
};
</script>
