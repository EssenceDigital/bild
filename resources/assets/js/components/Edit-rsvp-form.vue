<template>
  <v-slide-y-transition>
    <v-container fluid v-if="rsvp">
      <v-layout row wrap>
        <v-flex xs12 lg6>
          <v-text-field
            label="Name"
            v-model="form.name.value"
            :error-messages="form.name.errors"
          ></v-text-field>
        </v-flex>
        <v-flex xs12 lg6>
          <v-text-field
            label="Email"
            v-model="form.email.value"
            :error-messages="form.email.errors"
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
      </v-layout>
      <v-layout row>
        <v-flex xs12 lg3>
          <v-text-field
            :disabled="form.rsvp.value == 'No'"
            type="number"
            value="0"
            min="0"
            max="50"
            label="Individual tickets"
            v-model="form.tickets.value"
            :error-messages="form.tickets.errors"
          ></v-text-field>
        </v-flex>
        <v-spacer></v-spacer>
        <v-flex xs12 lg3>
          <v-text-field
            :disabled="form.rsvp.value == 'No'"
            type="number"
            value="0"
            min="0"
            max="50"
            label="Table of eight"
            v-model="form.tables.value"
            :error-messages="form.tables.errors"
          ></v-text-field>
        </v-flex>
        <v-spacer></v-spacer>
        <v-flex xs12 lg3>
          <v-text-field
            :disabled="form.rsvp.value == 'No'"
            type="number"
            value="0"
            min="0"
            max="50"
            label="Drink tickets"
            v-model="form.drink_tickets.value"
            :error-messages="form.drink_tickets.errors"
          ></v-text-field>
        </v-flex>
      </v-layout>
      <v-layout row wrap>
        <v-flex xs12>
          <v-textarea
            :disabled="form.rsvp.value == 'No'"
            rows="3"
            label="Allergies (if any)"
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
            label="Special request on seating arrangements"
            v-model="form.additional.value"
            :error-messages="form.additional.errors"
          ></v-textarea>
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
            Update
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
    props: ['rsvp'],

		data (){
			return {
				form: {
          id: {value: '', errors: []},
					name: {value: '', errors: []},
					email: {value: '', errors: []},
					rsvp: {value: '', errors: []},
					tickets: {value: '', errors: []},
					tables: {value: '', errors: []},
					drink_tickets: {value: '', errors: []},
					dietary: {value: '', errors: []},
					additional: {value: '', errors: []}
        },
        attending: [
          { text: 'Yes', value: 'Yes' },
          { text: 'No', value: 'No' }
        ],
        isSending: false,
			}
		},

    watch: {
			rsvp (rsvp){
				if(rsvp){
					Helpers.populateForm(this.form, rsvp);
				}
			}
    },

		components: {

		},
		methods: {

			send (){
        // Toggle loader
      	this.isSending = true;
        // If rsvp changed to no then cancel any possible tickets
        if(this.form.rsvp.value == 'No'){
          this.form.tickets.value = '';
        }
      	// Populate data for POST Request
      	let data = {};
      	for(let field in this.form){
      		data[field] = this.form[field].value;
      	}

        axios.post('/rsvp/update', data)
          .then((response) => {
            Helpers.clearForm(this.form);
    				Helpers.clearFormErrors(this.form);
            // Toggle loader
            this.isSending = false;

            this.$emit('saved', data);
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

			}
		}
	}
</script>
