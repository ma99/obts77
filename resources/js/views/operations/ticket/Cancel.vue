<template>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0 text-dark">Ticket Cancel</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item">
                  <router-link :to="{ name: 'dashboard' }">
                    <i class="fa fa-tachometer nav-icon"></i> Dashboard
                  </router-link>
                </li>
                <li class="breadcrumb-item active">Ticket Cancel</li>
              </ol>
            </div><!-- /.col -->
          </div><!-- /.row -->
        </div><!-- /.container-fluid -->
      </div>
      <!-- /.content-header -->

      <!-- Main content -->
      <section class="content">
        <div class="container-fluid">
          <div class="row justify-content-center">
            <div class="card w-75">
              <div class="card-header">
                Search By
              </div>
              <div class="card-body">
                <!-- <h5 class="border-bottom pb-2 mb-4">Search By</h5> -->
                <form>
                  <div class="form-row">
                    <div class="col-sm-4">
                      <div class="custom-control custom-radio mb-1">
                        <input type="radio" id="bookingRadio" name="customRadio" value="booking" v-model="searchBy" class="custom-control-input">
                        <label class="custom-control-label" for="bookingRadio">Booking</label>
                      </div>
                      <div class="custom-control custom-radio">
                        <input type="radio" id="phoneRadio" name="customRadio" value="phone" v-model="searchBy" class="custom-control-input">
                        <label class="custom-control-label" for="phoneRadio">Phone</label>
                      </div>
                    </div>
                    <div class="col-sm-7 col-md-8 mt-3 mt-sm-0 text-center">
                      <input type="text" class="form-control" :placeholder="placeholder" v-model="search" :disabled="!searchBy">

                      <div class="button-group mt-3 px-5 px-sm-2">
                        <button @click.prevent="submit()" class="btn btn-primary mr-2 mb-2 mb-md-0 px-5" :disabled="!isValid"> <i class="far fa-save mr-2"></i>
                        Search
                        </button>
                        <button @click.prevent="reset()" class="btn btn-warning" :disabled="!isValid"><i class="far fa-window-close mr-2"></i>
                        Cancel
                        </button>
                      </div>                      
                    </div>                    
                  </div>
                </form>
              </div>
            </div>
          </div>
          <!-- /.row -->

          <!-- Alert -->             
          <alert :show="showAlert" type="info">
            <i class="fas fa-info-circle fa-2x text-warning mr-2"></i>
            <span class="h4">{{responseMessage}}</span>
          </alert>                        
          <loader :show="loading"></loader>

          <!-- Info -->
          <div v-if="showTicketInfo" class="row justify-content-center py-3">
            <div class="card w-100">
              <div class="card-body bg-lightcyan">
                <div class="mx-auto col-12 col-sm-8">
                  <i class="fas fa-user-circle mx-2"></i>{{ user.name }} | 
                  <i class="fas fa-mobile-alt mx-2"></i>{{ user.phone }} | 
                  <i class="fas fa-envelope mx-2"></i>{{ user.email }}
                </div>
              </div>
            </div>
            <div class="card w-100">
              <div class="card-body p-0">                
                <div class="scrollbar">
                  <table class="table table-striped table-hover">
                    <thead class="bg-secondary">
                      <tr>
                        <th scope="col">#</th>
                        <th scope="col">Ref.</th>
                        <th scope="col">Amount</th>
                        <th scope="col">Created at</th>
                        <th scope="col">Journey</th>
                        <th scope="col">Seat/Seats</th>
                        <th scope="col">Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr v-for="(booking, index) in bookings" :key="index">
                        <th scope="row">{{ index+1 }}</th>
                        <td>{{booking.booking.id}}</td>
                        <td>{{booking.booking.amount}}</td>
                        <td>{{getDateTime(booking.booking.created_at)}}</td>
                        <td><span class="text-primary">{{getDate(booking.booking.date)}}</span></td>
                        <td>
                          <div class="custom-control custom-checkbox">
                            <input 
                              type="checkbox" 
                              class="custom-control-input"
                              :id="customCheck(booking.booking.id)"
                              v-model="selectAll[index]"
                              @click="currentBooking(booking, index)"
                            >
                            <label class="custom-control-label font-weight-bold" :for="customCheck(booking.booking.id)">Seats</label>
                          </div>
                          <div v-for="(seat, indx) in booking.seats" :key="indx" class="custom-control custom-checkbox">
                            <input 
                              type="checkbox" 
                              class="custom-control-input" 
                              :id="customCheck(booking.booking.id, indx)"
                              :value="{'bookingId': booking.booking.id, 'seat': seat}" 
                              v-model="checkedSeats"
                            >
                            <label class="custom-control-label" :for="customCheck( booking.booking.id, indx)">{{seat.seat_no}} </label>
                          </div>
                        </td>
                        <td>
                          <div>                                
                            <button v-on:click.prevent="cancel(booking)" class="btn btn-outline-danger">
                              <i class="far fa-trash-alt mr-2"></i>Cancel
                            </button> 
                          </div>
                        </td>
                      </tr>                     
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
          <!-- /Info -->

        </div><!-- /.container-fluid -->
      </section>
      <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
</template>

<script>
    import Alert2 from '../../../components/Alert2';  

    export default {
        props: {
          role: String
        },
        components: {          
          alert: Alert2
        },  
        data() {
          return {
            // actionStatus: '',
            bookings: [],
            booking: null,
            // checkedSeats: [],
            // ticket: {
              selectAll: [],
              checkedSeats: [],
            // },
            seats: [],
            // selectAll: false,
            loading: false,
            responseMessage: null,
            searchBy: null,
            search: null,
            showAlert: false,
            showTicketInfo: false,
            ticketInfo: {},
            user:{
              name: null,
              phone: null,
              email: null,
            },
          }
        },
        mounted() {
            console.log('Cancel Component mounted.')
        },
        
        computed: {
          isValid() {
            return true;
          },         
          placeholder() {
            let searchBy = this.searchBy ?? '';
            return `Enter ${searchBy} number here.`;
          },          
        },
        methods: {
          currentBooking(booking, index) {
            // console.log('iii', index)
            // console.log('iic', this.selectAll[index])
            if (this.selectAll[index] !== undefined) {
              // console.log('iiuuuuuuu11', this.selectAll[index])
              this.selectAll[index] = !this.selectAll[index];
            } else {
              this.selectAll[index] = true;
              // console.log('iiuuuuuuu22', this.selectAll[index])
            }

            if (!this.selectAll[index]) {
              this.checkedSeats = [];
              this.seats = [];
              this.booking = null;
              return;
            }
            //loop SelectAll, set others index undefined/false
            var selectedBookingIndex = index;
            this.selectAll.forEach((element, index) => {
               if (index != selectedBookingIndex) {
                this.selectAll[index] = false;
               }
             })
            var selected = [];
            var vm = this;
            this.booking = booking.booking;
            this.seats = booking.seats;            
            this.seats.forEach(seat => {
              selected.push({'bookingId': vm.booking.id, 'seat': seat});
            });
            this.checkedSeats = selected;
            console.log(this.checkedSeats);
          },
          getDateTime(date) {
            // if (this.isDate(date) === true) {
              let options = { year: 'numeric', month: 'short', day: 'numeric' };
              let dateTime = new Date(date);
              return dateTime.toLocaleString('en-GB', options);
          },

          getDate(date) {
            // 29-11-2021
            let options = { weekday: 'short', year: 'numeric', month: 'short', day: 'numeric' };
            let parts = date.split('-');             
            let mydate = new Date(parts[2], parts[1] - 1, parts[0]);
            // let mydate = new Date(`${parts[2]}-${parts[1]}-${parts[0]}`);
            console.log('JD=', mydate)
            return mydate.toLocaleString('en-GB', options); 
          },
          // isDate(date) {            
          //    return (new Date(date) !== "Invalid Date") && !isNaN(new Date(date));
          // },
          isAdmin() {
            return (this.role == 'super_admin' || this.role == 'admin') ?
                  true : false
          },
          isEmpty(object) {     
            return ( Object.keys(object).length === 0 ) ? true : false;            
          },
          hasNullPropertyUser(object) {
            if (object.hasOwnProperty('user')) {
              return (object.user === null || object.user === 'undefined') ? true : false;
            }
          },
          customCheck(bookingId, index=null) {
            if (index == null) {              
              return `customCheck${bookingId}`;
            }
            return `customCheck${bookingId}${index+1}`;
          },
          cancel(booking) {
            var vm = this;  

            swal({
              title: "Are you sure?",
              text: "This seat/seats will be Removed!",
              icon: "error",                 
              dangerMode: true,
              buttons: {
                  cancel: "cancel",
                  confirm: {
                    text: "Remove It!",
                    value: true,
                  },                                
              },
            })
            .then((value) => {
              if (value) {

                vm.loading = true;
                // vm.response = '';
                vm.showAlert = false;
                console.log('1')
                // let response = vm.deleteBookingsInServer(booking); //{booking:{}, seats: []}
                // let response = await vm.deleteBookingsInServer(booking); //{booking:{}, seats: []}
                /*response.then(message => {
                  vm.actionStatus = 'Removed';
                  vm.alertType = 'danger';
                  console.log('rr=', message)
                  // vm.callToAlert(response);
                  console.log('6')
                  vm.loading = false;
                  // vm.showAlert= true;                    
                });*/
                vm.callToDelete(booking);
                console.log('hold on')
                // console.log('5')
                /*vm.actionStatus = 'Removed';
                vm.alertType = 'danger';
                console.log('rr=', response)
                // vm.callToAlert(response);
                console.log('6')
                vm.loading = false;
                // vm.showAlert= true;                    */
              }                   
            });             
          },
          async callToDelete(booking) {
            console.log('process started')
            console.log('2')
            await this.deleteBookingsInServer(booking); //{booking:{}, seats: []}
            // response.then(msg => console.log('msg=', msg));
            // this.actionStatus = 'Removed';
            this.alertType = 'danger';
            // console.log('rr=', response)
            console.log('process end')
            this.loading = false;
            this.callToAlert();
            console.log('6')
            // this.showAlert= true;                    

          },
          async deleteBookingsInServer(booking) {
            var vm = this;
            let url = '/tickets/cancel';
            await axios.post(url, {
              bookings: this.checkedSeats,
            })            
            .then(function (response) {
              console.log(response);
              console.log('3');              
              vm.deleteBookingsInClient(booking); 
              console.log('5');              
              console.log('To b r', response.data)
              vm.responseMessage = vm.extractMessageFrom(response.data);
            })
            .catch(function (error) {
              console.log(error);
            });
          },
          extractMessageFrom(response) {
            return response.bookings[0];
          },
          deleteBookingsInClient(booking) {
            console.log('4')
             // let bookingIndex = this.getIndexBy(booking);
             console.log('bookingIndex',this.bookings.indexOf(booking));
             let bookingIndex = this.bookings.indexOf(booking);             
             
             this.deleteFromBookingsWhenAllSeatsSelected(booking, bookingIndex);
             this.deleteFromBookingsBy(this.checkedSeats);
          },
          deleteFromBookingsWhenAllSeatsSelected(booking, bookingIndex) {

            if (booking.seats.length === this.checkedSeats.length) {
                this.bookings.splice(bookingIndex, 1);
                this.checkedSeats = [];
                this.deleteSelectedFromAllSelect();
                // let i = this.selectAll.findIndex(element=> element === true);
                // this.selectAll.splice(i, 1);
              // this.callToAlert(response);
              // console.log('after delete', this.bookings);
              return;
             }
          },
          deleteSelectedFromAllSelect() {
            let i = this.selectAll.findIndex(element=> element === true);
            this.selectAll.splice(i, 1);
          },
          deleteFromBookingsBy(seats) {
            var vm = this;
            seats.forEach((element, si) => {
              console.log('_____________________',)
              console.log('seat', element.seat)
              // // console.log('1', this.bookings)
              // // console.log('2', vm.bookings)
              // console.log('seatIndex-si=', si);
              // let seatIndex = seats.indexOf(element);
              // console.log('seatIndex=', seatIndex);

              vm.bookings.forEach((booking, i) => {                
                console.log('bi=', i);
                // console.log('bookingSeat-i', vm.bookings[i].seats.indexOf(element.seat))
                console.log('bookingSeatIndex', booking.seats.indexOf(element.seat))

                let bookingSeatIndex = booking.seats.indexOf(element.seat);
                // console.log('bSIndex=', bookingSeatIndex);
                  if (bookingSeatIndex !== -1) {
                  console.log('--------------------');
                  console.log(`bookings[${i}]seats[${bookingSeatIndex}]`)
                  console.log('--------------------');
                  booking.seats.splice(bookingSeatIndex, 1);
                  // console.log('i=', i)
                  // console.log('bsi=', bookingSeatIndex)
                  // vm.bookings[i].seats.splice(bookingSeatIndex, 1);
                  // seats.splice(seatIndex, 1);
                  let ticketPrice = vm.getTicketPrice(booking.booking.amount, booking.booking.total_seats);
                  // let amount = vm.deduct(booking.booking.amount, ticketPrice);
                  booking.booking.amount = vm.deduct(ticketPrice, booking.booking.amount);
                  booking.booking.total_seats = vm.deduct(1, booking.booking.total_seats);

                  return;
                }
              });
            });
            this.checkedSeats = [];
          },
          getTicketPrice(totalAmount, toalSeats) {
            return (totalAmount/toalSeats);
          },
          deduct(value1, value2) {
            return (value2 - value1);
          },
          submit() {
            this.loading = true;  
            this.reset();           
            var vm = this;            
            // var url = this.isAdmin() ? '/tickets' : '/users/tickets' 
            var url = '/tickets';
            // axios.get(`/tickets/${this.searchBy}/${this.search}`)
            axios.get(url, {
                      params: {
                        searchBy: this.searchBy,
                        search: this.search
                      }
                })
                .then(function (response) {                  
                  response.data.error ? vm.error = response.data.error : vm.ticketInfo = response.data; 
                  // console.log(response.data)                 
                  // console.log('TT',vm.ticketInfo)                 
                  
                  if (vm.hasNullPropertyUser(vm.ticketInfo)) {
                    vm.showTicketInfo = false;
                    vm.callToAlert(response.data);
                    vm.loading = false;
                    return;
                  }
                  vm.setTicketInfo(vm.ticketInfo);
                  vm.loading = false;
            });          
          },
          callToAlert(response=null) {
            if (response !== null) {
             this.responseMessage = response.bookings[0];                
            }
             this.showAlert = true;  
          },
          setTicketInfo(ticket) {
            // this.bookings = ticket.bookings;
            this.bookings = Object.values(ticket.bookings);            
            this.setUserInfo(ticket.user);
            this.showTicketInfo = true;
          },
          setUserInfo(user) {            
            this.user = {
              name: user.name,
              phone: user.phone,
              email: user.email
            }
          },
          reset() {
            this.ticketInfo = {};
            this.bookings = [];
            this.checkedSeats = [];
            this.user = {
              name: null,
              phone: null,
              email: null,
            };
            this.responseMessage = null;
            this.showAlert = false;
          },
        },
    }
</script>
