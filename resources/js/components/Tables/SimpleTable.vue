
<template>
  <div>
    <md-table v-model="employes" :table-header-color="tableHeaderColor">
      <md-table-row slot="md-table-row" slot-scope="{ item }">
        <md-table-cell md-label="الاسم الشخصي">{{ item.personne.prenom }}</md-table-cell>
        <md-table-cell md-label="الاسم العائلي">{{ item.personne.nom }}</md-table-cell>
        <md-table-cell md-label="الهاتف">{{ item.personne.tel}}</md-table-cell>
      
       
       <md-table-cell md-label="العنوان">{{ item.personne.adresse }}</md-table-cell>
       
        <md-table-cell md-label="الأجرة">{{ item.salaire }}</md-table-cell>
        <md-table-cell md-label="تاريخ التشغيل">{{ item.date_recrutement }}</md-table-cell>
        <md-table-cell md-label="اختيار">
          <md-button :to="{name :'Employe Profile',params: {employe: item}}" class="md-info">عرض المعلومات</md-button>
          <md-button :to="{name: 'ShowForm',params: {employe: item}}" class="md-warning">تعديل</md-button>
          <md-button @click="destroyEmploye(item.id, item.personne.id)" class="md-danger">حدف</md-button>
        </md-table-cell>
      </md-table-row>
    </md-table>
  </div>
</template>

<script>
export default {
  name: 'simple-table',
  props: {
    tableHeaderColor: {
      type: String,
      default: ''
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
      employes: [],
      employe: {
        date_recrutement: null,
        salaire: "",
        personne_id: "",
        magasin_id: ""
      }
    };
  },
  created() {
    this.fetchEmployes();
  },
   methods: {
    fetchEmployes() {
      fetch("/api/employes")
        .then(res => res.json())
        .then(res => {
          //affecter res.data a articles
          this.employes = res.data;
          console.log(this.employes);
        })
        .catch(err => console.log(err));
    },
    destroyEmploye(idEmp, idPers) {
        if(confirm('Vous etes sur ?')){
        fetch(`/api/employe/${idEmp}`, {
          method:'delete'
        })
        .then(res => res.json())
        .then(res => {
          alert("Employe removed");
          fetch(`/api/personne/${idPers}`, {
          method:'delete'
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
    }
</script>