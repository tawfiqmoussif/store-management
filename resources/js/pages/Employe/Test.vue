<template>
  <div class="content">
    <div class="md-layout">
      <div class="md-layout-item md-medium-size-100 md-xsmall-size-100 md-size-60">
        <mdb-datatable :data="data" striped bordered arrows :display="3"/>
      </div>
    </div>
  </div>
</template>


<script>
import { mdbDatatable } from "mdbvue";
export default {
  name: "DatatablePage",
  components: {
    mdbDatatable
  },
  mounted() {
    //this.employe = this.$route.params.employe;
    //this.fetchAvances();
    fetch("api/avanceEmployes/1")
      .then(res => res.json())
      .then(json => {
        let keys = ["date", "montant"];
        let entries = this.filterData(json, keys);
        //columns
        this.columns = [
          {
            label: "تاريخ تسليم المبلغ",
            field: "date",
            sort: "asc"
          },
          {
            label: "المبلغ المدفوع للعامل بالدرهم",
            field: "montant",
            sort: "asc"
          }
        ];
        //rows
        entries.map(entry => this.rows.push(entry));
      })
      .catch(err => console.log(err));
  },
  methods: {
    filterData(dataArr, keys) {
      let data = dataArr.data.map(entry => {
        let filteredEntry = {};
        keys.forEach(key => {
          if (key in entry) {
            filteredEntry[key] = entry[key];
          }
        });
        return filteredEntry;
      });
      return data;
    }
    /*fetchAvances() {
      fetch(`/api/avanceEmployes/1`)
        .then(res => res.json())
        .then(res => {
          this.avances = res.data;
          var i;
          for(i=0;i<this.avances.length;i++){
            this.avancesT.rows.push({date: this.avances[i].date, montant: this.avances[i].montant});
          }
         
        })
        .catch(err => console.log(err));
    }*/
  },
  data() {
    return {
      avances: new Object(),
      columns: [],
      rows: []
      /* table: [],
        data: {
          columns: [
            {
              label: 'تاريخ تسليم المبلغ',
              field: 'date',
              sort: 'asc'
            },
            {
              label: 'المبلغ المدفوع للعامل بالدرهم',
              field: 'montant',
              sort: 'asc'
            }
          ],
          rows: [
          ]
        }*/
    };
  },
  computed: {
    data() {
      return {
        columns: this.columns,
        rows: this.rows
      };
    }
  }
};
</script>