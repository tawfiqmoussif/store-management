<template>
      <md-card class="md-card-profile">
          <div class="md-card-avatar">
            <img class="img" :src="photo_url">
          </div>
      
          <md-card-content>
            <div>
      
      
              <div>
      
                <label class="md-title" style="color: blue !important;">الاسم الشخصي : {{fournisseur.personne.prenom}}</label>
      
              </div>
      
              <div class="md-layout-item md-small-size-100 md-size-100">
      
                <label class="md-title" style="color: blue !important;">الاسم العائلي : {{fournisseur.personne.nom}}</label>
      
              </div>
      
              <div class="md-layout-item md-small-size-100 md-size-100">
      
                <label class="md-title" style="color: blue !important;">رقم الهاتف : {{fournisseur.personne.tel}}</label>
      
              </div>
      
              <div class="md-layout-item md-small-size-100 md-size-100">
      
                <label class="md-title" style="color: blue !important;"> العنوان: {{fournisseur.personne.adresse}}</label>
      
              </div>
      
      
              <div class="md-layout-item md-small-size-100 md-size-100">
      
                <label class="md-title" style="color: black !important;">تاريخ العمل : {{employe.id_fiscale}}</label>
      
      
              </div>
              <div class="md-layout-item md-small-size-100 md-size-100">
                <label class="md-title" style="color: blue !important;">الأجرة : {{employe.nom_marque}}</label>
      
              </div>
              
            </div>
      
          </md-card-content>
        </md-card>
</template>
<script>
  export default {
    name: 'four-card',
    data() {
      return {
        photo_url: '',
        photocopie_url: '',
        fournisseur: new Object(),
        fournisseur: {
          id_fiscale: "",
          nom_marque: "",
          personne_id: "",
          magasin_id: ""
        }
      }
    },
    created() {
      console.log('tttt'+this.fournisseur);
     this.fournisseur = this.$route.params.fournisseur;
      //this.photo_url = '/photos/' + this.employe.personne.photo;
      //this.photocopie_url = '/photoCopieCarteNational/' + this.employe.personne.photocopie_carte_national;
      console.log(this.fournisseur);
    }
  }

</script>
<style>

</style>