<template>
  <v-slide-y-transition>
    <v-container fluid>
      <v-layout row wrap>
        <v-flex xs12 lg6>
          <v-text-field
            label="Name"
            v-model="form.name.value"
            :error-messages="form.name.errors"
            hint="Personal or company name"
            persistent-hint
          ></v-text-field>
        </v-flex>
        <v-flex xs12 lg6>
          <v-text-field
            label="Email"
            v-model="form.email.value"
            :error-messages="form.email.errors"
            hint="For ticket invoicing and contact"
            persistent-hint
          ></v-text-field>
        </v-flex>
      </v-layout>

      <v-layout row wrap>
        <v-flex xs12 lg6>
          <v-select
            :items="attending"
            label="RSVP"
            v-model="form.rsvp.value"
            :error-messages="form.rsvp.errors"
          ></v-select>
        </v-flex>
        <v-flex xs12 lg6>
          <v-text-field
            :disabled="form.rsvp.value == 'No'"
            type="number"
            value="0"
            min="1"
            max="50"
            label="Number of tickets"
            v-model="form.tickets.value"
            :error-messages="form.tickets.errors"
          ></v-text-field>
        </v-flex>
      </v-layout>

      <v-layout row wrap>
        <v-flex xs12>
          <v-textarea
            :disabled="form.rsvp.value == 'No'"
            rows="3"
            label="Dietary concerns"
            v-model="form.dietary.value"
            :error-messages="form.dietary.errors"
          ></v-textarea>
        </v-flex>
        </v-flex>
      </v-layout>

      <v-layout row wrap>
        <v-flex xs12>
          <v-textarea
            :disabled="form.rsvp.value == 'No'"
            rows="3"
            label="Additional requests"
            v-model="form.additional.value"
            :error-messages="form.additional.errors"
          ></v-textarea>
        </v-flex>
        </v-flex>
      </v-layout>

      <v-layout row wrap>
        <v-flex xs12 lg6>
          <v-text-field
            type="number"
            min="0"
            max="10"
            :label="captcha"
            v-model="form.captcha.value"
            :error-messages="form.captcha.errors"
            hint="Prove you're not a robot"
            persistent-hint
          ></v-text-field>
        </v-flex>
        </v-flex>
      </v-layout>

      <v-layout row class="mt-3">
        <v-spacer></v-spacer>
        <v-flex xs-3>
          <v-btn
            @click="send"
            :loading="isSending"
            color="blue darken-4"
            dark
            block
          >
            Send Response
          </v-btn>
        </v-flex>
        <v-spacer></v-spacer>
      </v-layout>

    </v-container>
  </v-slide-y-transition>


</template>

<script>
  import axios from 'axios';
	import Helpers from './../app/helpers';

	export default{
    props: ['captcha'],

		data (){
			return {
				form: {
					id: {value: '', errors: []},
					name: {value: '', errors: []},
					email: {value: '', errors: []},
					rsvp: {value: '', errors: []},
					tickets: {value: '', errors: []},
					dietary: {value: '', errors: []},
					additional: {value: '', errors: []},
          captcha: {value: '', errors: []}
				},
        attending: [
          { text: 'Yes', value: 'Yes' },
          { text: 'No', value: 'No' }
        ],
        isSending: false,
        formSubmitted: false
			}
		},

		components: {

		},
		methods: {

			send (){
        // Toggle loader
      	this.isSending = true;
      	// Populate data for POST Request
      	let data = {};
      	for(let field in this.form){
      		data[field] = this.form[field].value;
      	}

        axios.post('/rsvp/send', data)
          .then((response) => {
            Helpers.clearForm(this.form);
    				Helpers.clearFormErrors(this.form);
            // Toggle loader
            this.isSending = false;
            // Update state
            this.formSubmitted = true;
            this.$emit('form-submitted', true);
          })
          .catch((error) => {
      			console.log(error);
      			// Toggle loader
      			this.isSending = false;

      			if(error.response){
	      			// Form validation errors
	      			if(error.response.data){
								// Check for error response from Laravel controller
								if(error.response.data.result == 'error'){
									this.$router.app.$emit('snackbar', {
										text: error.response.data.message
									});
								}
								// Form errors
								if(error.response.data.errors){
			      			// Cache errors
			      			let errors = error.response.data.errors;
			      			// Handle errors
                  Helpers.populateFormErrors(this.form, errors);
								}

	      			}
      			}
          });

			},

			failed (errors){
				Helpers.populateFormErrors(this.form, errors);
			}
		}
	}
</script>
