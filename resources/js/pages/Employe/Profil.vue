<template>
  <div class="content">
    <div class="md-layout">
      <div class="md-layout-item md-medium-size-100 md-size-50" style="margin-right: 300px;">
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
<script>
export default {
  name: "emp-card",
  data() {
    return {
      photo_url: "/photos/NoImage.png",
      photocopie_url: "/photos/NoImage.png",
      employe: new Object(),
      employeT: {
        date_recrutement: null,
        salaire: "",
        personne_id: "",
        magasin_id: ""
      }
    };
  },
  created() {
    this.employe = this.$route.params.employe;
    if(this.employe.personne.photo) { this.photo_url = "/photos/" + this.employe.personne.photo; }
    if(this.employe.personne.photocopie_carte_national){
 this.photocopie_url =
      "/photoCopieCarteNational/" +
      this.employe.personne.photocopie_carte_national;
    }
   
  }
};
</script>
<style>
</style>