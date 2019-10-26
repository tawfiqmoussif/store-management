<template>
  <div class="content">
    <div class="md-layout">
      <div class="md-layout-item md-medium-size-100 md-size-160">
        <YearCalendar
          :key="componentKey"
          v-model="year"
          :activeDates.sync="activeDates"
          @toggleDate="toggleDate"
          lang="ar"
          :showYearSelector="showYearSelector"
        ></YearCalendar>
      </div>
    </div>
  </div>
</template>

<script>
import YearCalendar from "vue-material-year-calendar";

export default {
  name: "emp-abscence",
  data() {
    return {
      year: 2019,
      newDates: new Array(),
      activeDates: new Array(),
      showYearSelector: true,
      etat: {
        employe_id: "",
        date: "",
        present: ""
      },
      employe: new Object(),
      etatsTable: null,
      datesTable: null,
      componentKey: 0
          };
  },
  created() {
    this.employe = this.$route.params.employe;
    this.rempCal();
  },
  components: {
    YearCalendar
  },
  methods: {
    forceRerender() {
      this.componentKey += 1;
    },
    toggleDate(dateInfo) {
      this.etat.date = dateInfo.date;
      this.etat.present = dateInfo.selected;
      this.etat.employe_id = this.employe.id;
      fetch("api/etat", {
        method: "post",
        body: JSON.stringify(this.etat),
        headers: {
          "content-type": "application/json"
        }
      })
        .then(res => res.json())
        .then(data => {
          if (dateInfo.selected == false) {
            fetch(`api/removeSalaire`, {
              method: "post",
              body: JSON.stringify(this.employe),
              headers: {
                "content-type": "application/json"
              }
            })
              .then(res => res.json())
              .then(data => {})
              .catch(err => console.log(err));
            var i;
            for (i = 0; i < this.activeDates.length; i++) {
              if (this.activeDates[i] === dateInfo.date) {
                this.rempCal();
                this.forceRerender();
              }
            }
          }
          //add salaire
          if (dateInfo.selected == true) {
            fetch(`api/addSalaire`, {
              method: "post",
              body: JSON.stringify(this.employe),
              headers: {
                "content-type": "application/json"
              }
            })
              .then(res => res.json())
              .then(data => {})
              .catch(err => console.log(err));
          }
        })
        .catch(err => console.log(err));
    },
    rempCal() {
      this.activeDates = [];
      fetch(`/api/etats/${this.employe.id}`)
        .then(res => res.json())
        .then(res => {
          this.etatsTable = res.data;
          var i;
          for (i = 0; i < this.etatsTable.length; i++) {
            if (this.etatsTable[i].present == true) {
              this.activeDates.push(this.etatsTable[i].date);
            }
          }
        })
        .catch(err => console.log(err));
    }
  }
};
</script>