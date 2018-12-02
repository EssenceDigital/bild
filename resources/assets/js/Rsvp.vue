<template>
  <v-app light>
      <v-content>
        <v-fade-transition duration="5">
          <section v-if="formSubmitted">
            <v-parallax height="550">
              <v-layout
                column
                align-center
                justify-center
              >
                <img src="images/bild-logo.png" alt="Vuetify.js" height="200">
                <h1 class="blue--text text--darken-4 mb-2 display-1 text-xs-center">Thank you!</h1>
                <div class="grey--text text--darken-2 subheading mb-3 text-xs-center">We've recieved your response</div>
              </v-layout>
            </v-parallax>
          </section>
        </v-fade-transition>

        <v-fade-transition>
          <section v-if="!formSubmitted">
            <v-parallax src="images/parallax.jpg" height="550">
              <v-layout
                column
                align-center
                justify-center
              >
                <img src="images/bild-logo.png" alt="Vuetify.js" height="200">
                <h1 class="blue--text text--darken-4 mb-2 display-1 text-xs-center">Awards of Excellence</h1>
                <div class="grey--text text--darken-2 subheading mb-3 text-xs-center">Do you plan to attend?</div>
              </v-layout>
            </v-parallax>
          </section>
        </v-fade-transition>


        <v-fade-transition>
          <section v-if="!formSubmitted">
            <v-layout
              row
              class="mt-5 mb-0"
            >
              <v-flex xs12 class="my-3 text-xs-center">
                <div class="text-xs-center">

                    <h2 v-if="!formSubmitted" class="headline">Please Submit Your RSVP</h2>



                </div>
              </v-flex>
            </v-layout>
            <v-layout
              row
              class="mt-1 mb-3"
            >
              <v-spacer></v-spacer>
              <v-flex xs11 lg6>
                <v-container grid-list-xl>
                  <rsvp-form :captcha="captcha" @form-submitted="formSubmitted = true"></rsvp-form>
                </v-container>
              </v-flex>
              <v-spacer></v-spacer>
            </v-layout>
          </section>
        </v-fade-transition>

        <v-footer v-if="!formSubmitted" absolute class="blue darken-4">
          <v-layout row wrap align-center>
            <v-flex xs12>
              <div class="white--text ml-3">
                Made with
                <a class="white--text" href="https://vuetifyjs.com" target="_blank">Vuetify</a>
              </div>
            </v-flex>
          </v-layout>
        </v-footer>
      </v-content>
  </v-app>
</template>

<script>
  import RsvpForm from './components/Rsvp-form';

  export default{
    props: ['captcha'],

    data() {
      return {
        formSubmitted: false
      }
    },

    components: {
      'rsvp-form': RsvpForm
    }
  }
</script>
