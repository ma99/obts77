<template>
<div>
    <slot v-bind="self">    
    </slot> 
</div>
   
</template>
<script>
    // import Modal from './AppModal'; 
    // const URL = './storage/images/bus-icon.png';
    export default {
      props: ['cities'],

       // components: {          
       //      'mymodal': Modal,          
       //  },     
      
      data() {
          return {            
              alertType: '',
              availableCityList: [],
              availableStopList: [],
              bookedSeatInfo: { },
              busId:'',
              busScheduleId:'',
              busError: false,
              buses:[],
              busTypes: [],
              bus: {
                checkedTypes: [],
              },            
              cityList:[],
              cityToList:[],
              dataErrors: [],
              discount: {
                amount: 0,
                code: ''
              },
              droppingStops: [],
              pickupStops: [],
              //error: false,
              error: {
                city: false,
                pickupPoint: false,
                droppingPoint: false
              },
              loading: false,
              message: '',
              modal: false,
              searchMini: false,
              showAlert: false, // for alert Component
              showSearch: true,
              showSchedule: false,              
              scheduleId:'',
              selection: '',
              startDate: '11-04-2021',               
              selectedBus: '',
              // selectedCityFrom: 'Dhaka',
              // selectedTo: 'Sylhet',
              selectedCityFrom: 'Sylhet',
              selectedTo: 'Dhaka',
              // selectedPickupPoint: '',
              // selectedDroppingPoint: '',
              stops: {
                selectedPickupPoint: '',
                selectedDroppingPoint: '',
              },
              //url: 'seatbooking',             
              url: 'bookings',             
              // seat display
              seatChar:["A","B", "C" , "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O"],                             
              seatNo: '',
              seatStatus: '',              
              seatError: false,                                 
              selectedSeat: [],
              seatList: [],              
              instanceOfScrollbarInfoTable: undefined,
              indexList: [],
              index: 2, // space starting from this index then 2+4, 6+4
              numberOfRow: '',              
              totalFare: 0,
              totalSeats: 0,              
              // end seat display
              //guestUser: true,   
              payment: {
                method: 'cash',
                transaction: ''
              },           
              userInfo: {
                id: '',
                name: '',
                phone: '',
                email:'',
                error: '',
              },
              userExist: false,
              form: new Form({  //data as object
                name: '',
                email:'',
                phone:'',
                //non form data
                bus_id: '',
                date: '',
                schedule_id: '',
                bus_schedule_id: '',
                selected_seats: '',
                total_seats: '',
                amount: '',
                pickup_point: '',
                dropping_point:'',
              })
          }
      },
      
      mounted() {
           console.log('Seat search Component ready.');
           //this.createIndexList();            
           //this.cityList = JSON.parse(this.cities);
           
           this.fetchCities();
           this.fetchStops();
           this.showDate();                      
           this.showDateMiniSearch();                      
           // this.enableScroll();         
            // Echo.channel('mychannel.1')
            //   .listen('SeatStatusUpdatedEvent', this.updateSeatStatus);             
          // this.eventListenThroughBroadcastChannel();
      },
      beforeUnmount() {
        this.instanceOfScrollbarInfoTable.destroy();
      },
      watch: {
       'form.phone'(val, oldVal) {
        this.getUserInfoIfExist(this.form.phone);
       },
       'selectedSeat.length'(value) { 
        this.totalSeats = value;
       },
       seatStatus() {        
        var type = this.seatStatus;
        switch (type) {
          case 'available':
            this.alertType = 'success';           
            break;            
          case 'booked':
           this.alertType = 'warning';
            break;          
          case 'confirmed':
            this.alertType = 'danger';           
            break;  
          case 'cancelled':
            this.alertType = 'info';
            break;
          default:
            console.log('Sorry, we are out of ' + type + '.');
        }
       },
       //////// 5feb /////
       // buses() {
       //  this.isBusAvailable();
       //  //this.sortBusByDepartureTime(); 
       // }, 
       /////
       // selectedCityFrom() {
       //    //console.log();
       //   // this.fetchCityToList(this.selectedCityFrom);                        
       //    //this.pickupStopsBy(this.selectedCityFrom);   // Pickup Area List based On From City       
          
       //   //this.arr.push(val);
       // },
       // selectedTo() {
       //    //this.buses=[];
       //    //this.droppingStopsBy(this.selectedTo);   // Pickup Area List based On From City       
       // },      
       
        seatList() {
            this.createIndexList();
        }
      },
      computed: {
        // userNotExist() {        
        //   return (!this.userExist ||
        //     this.userInfo.error
        //     )
        //    ? true : false;
        // },
        self() { return { ...this } },

        styles() {
          return {
           'background-image': `url(${URL})`,
            'background-repeat': 'no-repeat',
            'background-size': 'cover'
          }
        },

        totalAmount() {
          let netTotal = this.bookedSeatInfo.amount + this.discount.amount;
          return netTotal;
        },
        isValidDate() {

          // today = new Date()
          // days = 86400000 //number of milliseconds in a day
          // fiveDaysAgo = new Date(today - (5*days))
          
          const days = 86400000;

          let today = new Date();        
          
          let startDate = this.convertStringToDate(this.startDate)

          let searchDate = new Date(startDate - (1*days))

          // to be deleted
          let dateString = this.convertDateToString(searchDate)

          // console.log('T=', today)
          // console.log('SrchD=', startDate)
          // console.log('prev day=', searchDate)
          // console.log('date str =', dateString)
          // del

          if(searchDate <= today){
            return true;
          }
          return false;
        },
        isValidSearchMini() {
          if (this.showSchedule == true && 
              this.searchMini == true)
            return true;
          return false;
        },
        busesByType() {
          const length = this.bus.checkedTypes.length;
          if (length === 0) {
            return this.buses;
          }
          return this.buses.filter(bus => { //1
            for (let i = 0; i < length; i++) {
              if (bus.bus_type == this.bus.checkedTypes[i]) {
                return bus;
              }
            }
            return false;
          })
        },
        showDataErrors() {
          return (this.dataErrors.length > 0) ? true : false;
        },
        // routeName() {
        //   return '/pay/'+this.bookedSeatInfo.booking_ref;
        // },
        // totalFareForSelectedSeats() {          
        //   var fare = 0;
        //   let len = this.selectedSeat.length;
        //   for (var i=0; i<len; i++){
        //     //fare = fare + parseInt(this.selectedSeat[i].fare, 10);
        //     fare = fare + parseInt(this.getFareFor(this.selectedSeat[i]), 10);
        //   }
        //   console.log('total fare:', fare);
        //   console.log('total seats:', len);
        //   this.totalFare = fare; 
        //   this.totalSeats = len;         
        // },
        disablePayButton() {
          if ( Object.keys(this.bookedSeatInfo).length === 0 ) return true; // empty object

          if (this.payment.method == 'pos') { 
            return ( this.payment.transaction == ''  || this.bookedSeatInfo.booking_ref == '') ?
                true : false;
          }
          return ( this.bookedSeatInfo.booking_ref == '' ) ?
                true : false;
        },
        // validPaymentOption() {
        //   return ( this.payment.method == 'pos' && 
        //     this.payment.transaction != "" ) ?
        //     true : false;
        // },
        isDisabled() {        
          return ( this.selectedCityFrom == "" || this.selectedTo == "" || this.startDate =='' || !this.validJourneyDate ) ? true : false;
       },

       validJourneyDate() {
        //let today = new Date().toISOString().slice(0, 10);
        let date = this.startDate.split('-');

        let today = new Date();
        let dateOfJourney = new Date(`${date[2]}-${date[1]}-${date[0]} 23:50:00`); //yyyy-mm-dd        
        return (dateOfJourney >= today) ? true : false;
       },
        //showSelectedSeatList() {
        isSeatSelected() {
          let len = this.selectedSeat.length;
          return ( len >0 ) ? true : false;
        },
        isValid() {
            return this.isSeatSelected != false &&
              this.stops.selectedPickupPoint != '' &&
              this.stops.selectedDroppingPoint != ''
          },
        isSeatBooked() {
          let len = Object.keys(this.bookedSeatInfo).length;
          //return ( len >0 ) ? true : false;
          if (len >0) {
            this.showSearch = false;
            return true;
          } 
          return false;
        },
      },
      methods: {
        hello() {
          console.log('hhhhhhhhhhhhhhhh')
        },
        applyDiscount() {
          //bookedSeatInfo
          console.log('discount')
          let code = this.discount.code.toUpperCase();

          // this.loading = true;
          axios.post('/discount', {
            code: code,
            amount: this.totalFare
          })
          .then(response => {
            console.log(response)
          })
          .catch(error => {
            console.log(error)
          })

        },
        handleSearch(day) {
          const days = 86400000;                    
          const startDate = this.convertStringToDate(this.startDate)
          // console.log('sssss', startDate)
          
          if (day == 'prev') {
            // let searchDate = new Date(startDate - (1*days))
            let searchDate = this.daysToDate('sub', 1, startDate);
            let dateString = this.convertDateToString(searchDate)
            this.startDate = dateString;
            this.searchBus();            
            return;
          }

          
          // let searchDate = startDate.setDate(startDate.getDate() + 1);
          // let searchDate = this.addDays(startDate, 1);
          let searchDate = this.daysToDate('add', 1, startDate);

          let dateString = this.convertDateToString(searchDate)
          this.startDate = dateString; 

          // console.log('SrchD=', startDate)
          // console.log('next day=', searchDate)
          // console.log('date str =', dateString)
          this.searchBus();
        },
        handleSearchMini() {
          this.searchMini = true;
          this.showDateMiniSearch()
        },
        convertDateToString(date) {
          // var d = new Date(date);
          return [
            ('0' + date.getDate()).slice(-2),
            ('0' + (date.getMonth() + 1)).slice(-2),
            date.getFullYear()
          ].join('-');          
        },
        convertStringToDate(dateString) {
          // var dateString = "23-10-2015"; // Oct 23

          let date = dateString.split("-");

          // month is 0-based, that's why we need dataParts[1] - 1
          // Convert String Using Number()
          // return new Date(Number(dateParts[2]), Number(dateParts[1]) - 1, Number(dateParts[0])); 
           return new Date(`${date[2]}-${date[1]}-${date[0]} 23:50:00`); //yyyy-mm-dd        

        },
        convertToDate(string) {
          let date = string.split("-");
          let mydate = new Date(date[2], date[1] - 1, date[0]); 
          // return mydate.toDateString();
          return mydate.toLocaleDateString('en-US', {
              day : 'numeric',
              month : 'short',
              year : 'numeric',
              // weekday: 'long'
          });
        },
        // addDays(date, days) {
        //   let result = new Date(date);
        //   result.setDate(result.getDate() + days);
        //   return result;
        // },
        daysToDate(action, days, date) {
          const result = new Date(date);

          if (action == 'add') {
           result.setDate(result.getDate() + days);
           return result;
          }

          result.setDate(result.getDate() - days);          
          return result;
        },
        handleCheckedTypes(e) {
          console.log('evnt-', e)
        },
        addFareToTotal(seat) {
          let fare = parseInt(this.getFareFor(seat), 10);
          this.totalFare = this.totalFare + fare;
          console.log('total fare=', this.totalFare)
        },
        removeFilter(name) {
          let i = this.bus.checkedTypes.indexOf(name);
          this.bus.checkedTypes.splice(i, 1); 
        },
        removeFareFromTotal(seat) {
          let fare = parseInt(this.getFareFor(seat), 10);
          this.totalFare = this.totalFare - fare;
          console.log('total fare=', this.totalFare)
        },
        handleCityFromInputEvent(value) {
          // console.log('ppppp=', value)
          this.selectedCityFrom = value
        },
        handleCityToInputEvent(value) {
          // console.log('ppppp=', value)
          this.selectedTo = value
        },        
        eventListenThroughBroadcastChannel() {
          Echo.channel('mychannel')
              .listen('SeatStatusUpdated', this.updateSeatStatus); 
        },
        getIdOfCity(name) {
          return this.availableCityList.find(city => city.name == name).id;
        },
        getUserInfoIfExist(phone) {
          if (phone.length < 11) {
            this.userInfo.error = 'Phone number not given or Invalid number';
            this.resetUserInfo();
            return;
          }
          this.loading = true;          
          this.userInfo.error = ''; 
          this.resetUserInfo();
          var vm = this;                
          axios.get(`/users/${phone}`)
              .then(function (response) {                  
                response.data.error ? vm.error = response.data.error : vm.userInfo = response.data;
                if( !vm.isEmpty(vm.userInfo) ){                  
                  vm.userExist = true;
                  vm.userInfo.error = '';
                  vm.fillupUserForm(vm.userInfo);
                  //console.log('not empty');                 
                }       
                vm.loading = false;
          });
        },
        fillupUserForm(userInfo) {          
          this.form.phone = userInfo.phone;
          this.form.name = userInfo.name;
          this.form.email = userInfo.email;          
        },
        isEmpty(obj) {
          //console.log('lenn='+ Object.values(obj).length);
          //return Object.keys(obj).length === 0;
          return Object.values(obj).length <= 1;
        },
        resetUserInfo() {
          this.userExist = false;
          this.form.name = '';
          this.form.email = '';
        },
        setSearchMini(status) {
          if (status == 'false') {
            this.searchMini = false;
            return; 
          }
          this.searchMini = true;
        },
        sortBusByDepartureTime() {
          var vm = this;
          this.buses.sort(function(a, b) {
            var timeA = vm.convertTime12to24(a.departure_time);
             // ignore upper and lowercase
            var timeB = vm.convertTime12to24(b.departure_time );// ignore upper and lowercase
            if (timeA < timeB) {
              return -1;
            }
            if (timeA > timeB) {
              return 1;
            }
            // names must be equal
            return 0;
          });
        },
        showTheModal(modalId, show) {                    
          if (show) {

            $(`#${modalId}`).modal({
              backdrop: 'static'
            })    
            return;
          }
          $(`#${modalId}`).modal('hide');    
        },
        convertTime12to24(time12h) {
          const [time, modifier] = time12h.split(' ');

          let [hours, minutes] = time.split(':');

          if (hours === '12') {
            hours = '00';
          }

          if ( modifier === 'PM' || modifier === 'pm') {
            hours = parseInt(hours, 10) + 12;
          }

         // return `${hours}:${minutes}`;
          return `${hours}${minutes}`;
        },
        enableScroll() {
          this.instanceOfScrollbarInfoTable = OverlayScrollbars(document.getElementsByClassName("info-scroll"),
                    { 
                      className: "os-theme-dark",
                      sizeAutoCapable: true,
                      scrollbars: {
                        autoHide: "never",
                        clickScrolling: true
                      } 
                    })
        },   
        getFareFor(seat) {
          //console.log(seat);
          let combinedFare = this.isCombinedType(seat.fare);
          if (combinedFare) {
            let fares = seat.fare.split('|');
            let f1, f2;
            f1 = parseInt(fares[0], 10);
            f2 = parseInt(fares[1], 10);                        

            return (seat.special) ? 
                    ( (f1 > f2) ? f1 : f2 ) : ( (f1 < f2) ? f1 : f2 );
          }
          return seat.fare;
        },        
        isCombinedType(fare) {
          return fare.includes('|') ? true : false;
        },
        close() {
                this.modal = false;
                this.loading = false;                
                this.selectedSeat = [];
                if(this.form.errors) {
                  this.form.errors.clear();                
                }
        },
        // isBusAvailable() {
        //   let len = this.buses.length;
        //   //this.showSchedule = ( len >0 && this.error==false && this.selectedTo !=="" ) ? true : false;  //true show table
        //   this.showSchedule = ( len >0 ) ? true : false;  //true show table
        // },
        isSeatBuying(seatStatus){
          return seatStatus == 'buying' ? true : false;
        },
        updateSeatStatus(evnt) {          
          var seatNo = evnt.seat.seat_no;
          console.log('seaaatno=', seatNo);
          //var vm = this;
          if ( this.busScheduleId == evnt.busScheduleId &&
              this.startDate == evnt.date) {
            
              var indx = this.seatList.findIndex(function(seat){ 
                // here 'seat' is array object of selectedSeat array
                return seat.seat_no == seatNo;
              });

             // this.seatList[indx].status = "booked"; //prev
            this.seatList[indx].status = evnt.seat.status;
            this.seatNo = seatNo;
            this.seatStatus = evnt.seat.status;         
            this.showAlert = true;
          }
          console.log(evnt.seat.seat_no, evnt.busScheduleId, evnt.date);
        },
        async searchMain() {
          this.loading = true;
          // console.log('sMMMM')

          await this.searchBus()
          
          // console.log('sMMEEEEE')

          this.loading = false;

           if (this.busError) {
              this.seatNotAvailableAlert('SCHEDULE', 'warning');
              return;
           }
           this.sortBusByDepartureTime(); 
           this.setBusTypes();
           if (this.showSearch == true) {
            this.showSearch = false;
           }
           if (this.searchMini == true) {
            this.searchMini = false;
         }
        },
        // searchBus() {         
        //   console.log(this.startDate);

        //   this.busError = false;
        //   // this.loading = true;
           
        //   var vm = this;
        //   this.buses ='';
        //   axios.get('/search', {
        //       params: {                
        //         // from: this.selectedCityFrom,
        //         // to: this.selectedTo,
        //         from: this.getIdOfCity(this.selectedCityFrom),
        //         to: this.getIdOfCity(this.selectedTo),
        //         date: this.startDate,              
        //       }  
        //     })          
        //     .then(function (response) {             
        //        console.log(response.data);
               
        //        response.data.error ? vm.busError = response.data.error : vm.buses = response.data;
        //        vm.loading = false;
        //        if (vm.busError) {
        //           vm.seatNotAvailableAlert('SCHEDULE', 'warning');
        //           return;
        //        }
        //        vm.sortBusByDepartureTime(); 
        //        vm.setBusTypes();
        //        if (vm.showSearch == true) {
        //         vm.showSearch = false;
        //        }
        //        if (vm.searchMini == true) {
        //         vm.searchMini = false;
        //        }               
        //     });
        //     //888888
        //     /*this.loading = false;
        //      if (this.busError) {
        //         this.seatNotAvailableAlert('SCHEDULE', 'warning');
        //         return;
        //      }
        //      this.sortBusByDepartureTime(); 
        //      this.setBusTypes();
        //      if (this.showSearch == true) {
        //       this.showSearch = false;
        //      }
        //      if (this.searchMini == true) {
        //       this.searchMini = false;
        //      }*/
        //     //888
        // },
        async searchBus() {         
          // console.log(this.startDate);

          this.busError = false;
          this.loading = true;
          console.log('sMMMM')           
          var vm = this;
          this.buses ='';

          await this.getBusData().then(response => {
            // console.log(response.data);

            response.data.error ? vm.busError = response.data.error : vm.buses = response.data;
             
             vm.loading = false;

             console.log('sMMMMEEEE1111')
             if (vm.busError) {
                vm.seatNotAvailableAlert('SCHEDULE', 'warning');
                return;
             }
             vm.sortBusByDepartureTime(); 
             vm.setBusTypes();
             if (vm.showSearch == true) {
              vm.showSearch = false;
             }
             if (vm.searchMini == true) {
              vm.searchMini = false;
             }               
             if (vm.showSchedule == false) {
              vm.showSchedule = true;
             }               

          })
          console.log('sMMMM222222222')
          // axios.get('/search', {
          //     params: {                
          //       // from: this.selectedCityFrom,
          //       // to: this.selectedTo,
          //       from: this.getIdOfCity(this.selectedCityFrom),
          //       to: this.getIdOfCity(this.selectedTo),
          //       date: this.startDate,              
          //     }  
          //   })          
          //   .then(function (response) {             
          //      console.log(response.data);
               
          //      response.data.error ? vm.busError = response.data.error : vm.buses = response.data;
          //      /*vm.loading = false;
          //      if (vm.busError) {
          //         vm.seatNotAvailableAlert('SCHEDULE', 'warning');
          //         return;
          //      }
          //      vm.sortBusByDepartureTime(); 
          //      vm.setBusTypes();
          //      if (vm.showSearch == true) {
          //       vm.showSearch = false;
          //      }
          //      if (vm.searchMini == true) {
          //       vm.searchMini = false;
          //      }*/               
          //   });
        },
        async getBusData() {
          try {
            const response = await axios.get('/search', {
              params: {                
                // from: this.selectedCityFrom,
                // to: this.selectedTo,
                from: this.getIdOfCity(this.selectedCityFrom),
                to: this.getIdOfCity(this.selectedTo),
                date: this.startDate,              
              }  
            })
            return response;
          }
          catch (error) {
            console.log(error)
            this.loading = false
          }

        },
        setBusTypes() {
          const buses = this.buses;
          if (buses.length == 0) return;
          let result = _(buses)
          .groupBy(bus => bus.bus_type)
          .map((value, key) => ({type: key, info: value}))
          .value();
          
          console.table(result);
          this.busTypes = result;
        },
        setBusTypeCheckId(id) {
          let i = id+1;
          console.log('cs=', i)
          return `busTypeCheckId${i}`
        },
        //viewSeatsOf(busScheduleId, busId, busFare) {
        viewSeatsOf(bus) {
          // console.log('busSchId=', scheduleId);
          // console.log('busId=', busId);
          this.selectedBus = bus;
          this.seatError = false;
          this.selectedSeat = [];
          this.busScheduleId = bus.bus_schedule_id;
          this.busId = bus.bus_id;
          // this.selectedPickupPoint = '';
          // this.selectedDroppingPoint = '';
          this.stops.selectedPickupPoint = '';
          this.stops.selectedDroppingPoint = '';
          this.totalFare = 0;
          this.loading = true;
          this.pickupStopsBy(this.selectedCityFrom);
          this.droppingStopsBy(this.selectedTo);
          var vm = this;
          axios.get('/viewseats/buses/'+bus.bus_id, {
              params: {
                // from: this.selectedCityFrom,
                // to: this.selectedTo,
                // date: this.startDate,
                bus_schedule_id: bus.bus_schedule_id,
                bus_id: bus.bus_id,
                bus_fare: bus.fare,
                date: vm.startDate,
              }  
            })          
            .then(function (response) {             
                console.log(response.data);
                response.data.error ? vm.seatError = response.data.error : vm.seatList = response.data;
                vm.loading = false;
                if (vm.seatError) {
                  vm.seatNotAvailableAlert('SEAT PLAN', 'error');
                  return;
                }
                // vm.modal = true;
                vm.showTheModal('seatSelection', true);
            });
        },

        seatNotAvailableAlert(val, type) {
          swal({
            //title: "Sorry! Not Available",
            title: val,
            text: "Not Available!",
           // title: '<span style="color:#F8BB86"> <strong>'+val+'</strong></span></br>Not Available. Sorry!',
            //text: '<span style="color:#F8BB86"> <strong>'+val+'</strong></span> Not Available.',
            //html: true,
            //type: "info",
            //type: type,
            icon: type,
            timer: 3000,
            //showConfirmButton: false,
            closeOnClickOutside: true,
          });
        },
        seatBookingByStaff() {         
          // this.url = (this.userInfo.hasOwnProperty('id')) ? `bookings/byStaff/${this.userInfo.id}` : 'bookings/byStaff';
          // if (this.userInfo.name == '' && this.form.name != '' ) {
          //   this.userInfo.name = this.form.name;
          // }
          if (this.userExist) {
            this.url = `bookings/byStaff/${this.userInfo.id}`;
          } else {
            this.url = 'bookings/byStaff';
            this.userInfo.phone = this.form.phone;
            this.userInfo.name = this.form.name;
          }
          var vm = this; 
          swal({
            title: "Are you sure?",
            text: "This will register a BOOKING for you",
            icon: "info",                 
            //dangerMode: true,
            buttons: {
                cancel: "cancel",
                confirm: {
                  text: "Yes! Book It.",
                  value: true,
                },                                
            },
          })
          .then((value) => {
            if (value) {

              vm.loading = true;
              vm.buses = []; // hide table
              vm.changeStatusOfSelectedSeat(vm.selectedSeat); 
              // // non form data  
              vm.form.bus_id = vm.busId;
              vm.form.date = vm.startDate;
              //vm.form.schedule_id = vm.scheduleId;
              vm.form.bus_schedule_id = vm.busScheduleId;
              vm.form.selected_seats = vm.selectedSeat;
              vm.form.total_seats = vm.totalSeats;
              vm.form.amount = vm.totalFare; 
              vm.form.pickup_point = vm.stops.selectedPickupPoint; 
              vm.form.dropping_point = vm.stops.selectedDroppingPoint; 


              vm.form.post(vm.url)
                  //.then(response => alert('Wahoo!'));
              .then(function (response) {
                 //console.log(response.data)
                 vm.selectedSeat= [];                                  
                 vm.bookedSeatInfo = response;
                 vm.modal = false;
                 vm.loading = false;
                 //console.log('res=', response);
              })
              .catch(function (error) {
                console.log(error);
                vm.loading = false;
              });
              
            } 
            
          }); 
        },
        seatBookingByUser() {          
          var vm = this; 
          swal({
            title: "Are you sure?",
            text: "This will register a BOOKING for you",
            icon: "info",                 
            //dangerMode: true,
            buttons: {
                cancel: "cancel",
                confirm: {
                  text: "Yes! Book It.",
                  value: true,
                },                                
            },
          })
          .then((value) => {
            if (value) {

              vm.loading = true;
              vm.buses = []; // hide table
              vm.changeStatusOfSelectedSeat(vm.selectedSeat);               

              axios.post(vm.url, {
                //bus_id: vm.busId,
                date: vm.startDate,
                //schedule_id: vm.scheduleId,
                bus_schedule_id: vm.busScheduleId,
                selected_seats:vm.selectedSeat,
                total_seats: vm.totalSeats,
                amount: vm.totalFare,
                pickup_point:  vm.stops.selectedPickupPoint,
                dropping_point: vm.stops.selectedDroppingPoint 
              })                           
              .then(function (response) {
                 //console.log(response.data)
                 vm.selectedSeat= [];
                 vm.bookedSeatInfo = response.data;
                 vm.loading = false;
                 vm.modal = false;
                 // response.data.error ? vm.busError = response.data.error : vm.buses = response.data;
              })
              .catch(function (error) {
                //console.log('error='+ error);
                console.log(error.response.data.errors);
                vm.dataErrors = Object.values(error.response.data.errors);
                console.log(vm.dataErrors);
                vm.loading = false;
              });              
            } //if            
          }); 
        },
        // showDataErrors() {
        //   return (this.dataErrors.length > 0) ? true : false;
        // },
        changeStatusOfSelectedSeat(selectedSeat) {
          var vm = this;
          selectedSeat.forEach( function(seat){
            seat.status = (vm.url == 'bookings') ? 'booked' : 'buying';
            //seat.status = 'buying';
          });
        },
        fetchCities() {
          this.loading = true;
          this.availableCityList= [];            
          var vm = this;                
          axios.get('/api/cities')  
              .then(function (response) {
                 response.data.error ? vm.error = response.data.error : vm.availableCityList = response.data;
                 vm.loading = false;
          });
        },
        fetchStops() {
          this.loading = true;
          this.availableStopList= [];            
          var vm = this;                
          axios.get('/api/stops')  
              .then(function (response) {
                 response.data.error ? vm.error = response.data.error : vm.availableStopList = response.data;
                 vm.loading = false;
          });
        },        
        // getCityIdBy(cityName) {
        //   let city = this.availableCityList.find(city => city.name == cityName);
        //   return city.id;
        // },
        pickupStopsBy(city) {          
          this.error.pickupPoint = false;
          this.loading = true;
          let cityId = this.getIdOfCity(city);      
      
          this.pickupStops = [];          
          this.pickupStops =  this.availableStopList.filter(stop => stop.city_id == cityId);
          this.loading = false;
        },

        droppingStopsBy(city) {          
          this.error.droppingPoint = false;
          this.loading = true;
          let cityId = this.getIdOfCity(city);
          
          this.droppingStops = [];          
          this.droppingStops =  this.availableStopList.filter(stop => stop.city_id == cityId);
          this.loading = false;
        },        

        showDate() {
          var vm = this;
          $('#sandbox-container .input-group.date').datepicker({
              format: 'dd-mm-yyyy',                        
              startDate: '0d',
              todayHighlight: true,
              autoclose: true
          }).on("changeDate", () => {vm.startDate = $('#sandbox-container #startDate').val()});

        },
        showDateMiniSearch() {
          var vm = this;
          $('#sandbox-container-mini .input-group.date').datepicker({
              format: 'dd-mm-yyyy',                        
              startDate: '0d',
              todayHighlight: true,
              autoclose: true
          }).on("changeDate", () => {vm.startDate = $('#sandbox-container-mini #startDateMini').val()});

        },
        testDate() {
          console.log(this.startDate); // the startDate value is ''
        },
        
        /*** seat display methods ******/
        createIndexList() {
            this.indexList=[];
            var index = this.index;
            //var numberOfRow = this.numberOfRow;            
            var seatListLength =  this.seatList.length;
            // if (seatListLength < 5 ) {
            //     this.indexList.push(index);
            //     return;
            // } 
            
            var numberOfRow = (seatListLength-1) /4; //2
            this.numberOfRow = numberOfRow;
            var r;
            for ( r=1; r<numberOfRow; r++ ) { 
                this.indexList.push(index);
                index = index+4; 
                //console.log('index', index);
            }
        },

        emptySpace(index, seatNo) {           
            
            if ( this.isFiveCol(seatNo) ) {
              return false; // no need empty space between columns
            }
            /*var seatNumber = parseInt(seatNo.match(/\d+/),10);            
            return ( (seatNumber % 3) == 0 ) ? true : false;*/
            return this.isEmptySpaceAvailable(index);

        },
        
        isFiveCol(seatNo) {          
          /*var seatListLength =  this.seatList.length;
          var numberOfRow = (seatListLength-1) /4; //2*/
          var lastRowChar = this.seatChar[numberOfRow-1] || ''; //B
          var numberOfRow = parseInt(this.numberOfRow);
          //var lastRowChar = this.seatChar[numberOfRow-1]; //B
          lastRowChar = lastRowChar.trim();
          
          var seatChar = seatNo.substr(0, 1); //extract char from seat no
          return ( lastRowChar == seatChar ) ? true : false ;
        },

        isEmptySpaceAvailable(index) {
            var val = this.indexList.find( function(indx) {                            
                return indx == index;
            });
            return (index == val) ? true : false;
        },

        toggle(seat) {
          // console.log('clicked');
          // console.log(seat.no);
          seat.checked = !seat.checked;                         
              if (seat.checked) {
                //console.log('seat checked=', seat.checked);
                //this.addSeat(seat.seat_no); // to selectedSeat array               
                this.addSeat(seat); // to selectedSeat array               
                this.addFareToTotal(seat);
                return ;
              }
              //console.log('seat NOT checked=', seat.checked);               
              this.removeSeat(seat.seat_no, seat); // to selectedSeat array 
              // this.removeFareFromTotal(seat);                           
        },
        addSeat(seat) {
          //console.log('+', seatNo);
          this.selectedSeat.push({
          seat_no: seat.seat_no,
          fare: seat.fare,
          special:seat.special,
          status: 'booked' //'selected'
          });
          this.sortSelectedSeat();
        },
        sortSelectedSeat(){
          this.selectedSeat.sort(function(a, b) {
            var nameA = a.seat_no.toUpperCase(); // ignore upper and lowercase
            var nameB = b.seat_no.toUpperCase(); // ignore upper and lowercase
            if (nameA < nameB) {
              return -1;
            }
            if (nameA > nameB) {
              return 1;
            }
            // names must be equal
            return 0;
          });
        },
        removeSeat(seatNo, seat) {                    
          this.assignSeatCheckedStatusFalseInSeatList(seatNo); // checked = false 
          this.removeSeatFromSelectedSeat(seatNo);
          this.removeFareFromTotal(seat);
        },
        assignSeatCheckedStatusFalseInSeatList(seatNo) {         
          let index = this.seatList.findIndex(seat =>              
            seat.seat_no == seatNo &&
            seat.status == 'available'
          );
          //let index = this.seatList.indexOf(seat);
          this.seatList[index].checked = false;               
        },
        removeSeatFromSelectedSeat(seatNo) {
          let index = this.selectedSeat.findIndex(seat =>            
             seat.seat_no == seatNo
          );
          //let index = this.selectedSeat.indexOf(seat);      
          this.selectedSeat.splice(index, 1);     
        },
        isDisabledSeatSelection(seatStatus) {
          //console.log('disableSelection=', seatStatus);
          return ( seatStatus == 'booked' || 
              seatStatus == 'buying' ||
              seatStatus == 'confirmed' || 
              seatStatus == 'n/a' ) 
              ? 
              true : false;
        }        
        // end display methods
        // totalFareForSelectedSeats(seat) {
        //   console.log('Seatfare=', seat.fare);
        //   let fare;
        //   fare = parseInt(seat.fare, 10) + this.totalFare;
        //   this.totalFare = fare;
        //   console.log('fare=', fare);
        //  return fare;
        // }
      }
      
    }              
</script>

<style lang="scss" scoped>
  
  // /*[v-cloak] { display:none; }*/
  .search-form {
    background: linear-gradient(0deg, #8BC34A, #FFF59D);
    padding: 1.5rem 0;
    border-radius: 0.27rem;
  }
  
 .seat-error {
    text-align: center;
  }

#app .seat-layout {
      //padding-left: 50px;
      // .row {
      //   margin-left: 0px;
      // }
      display: flex;
      flex-wrap: wrap;
      justify-content:  center;
      button {               
        height: 34px; //50px;
        margin: 10px 10px 0 0;
        font-size: 0.8rem;
        &.col-xs-2 {
          width: 15.666667%;
        }
        &.col-xs-offset-2 {
          margin-left: 17.666667%;
        }
        &.is-white {
          background-color: #fff; 
          border-width: 0;
          color: #0a0a0a;
        }
      }   
  }
  
  div.row.driver-seat {      
    height: 4rem;
    position: relative;
  }
  div.row.driver-seat > button {
    position: absolute;
    top: 0;
    right: 10%;
  }  

  /* seat display */
  .is-active {
    background-color: green;
    color: #fff;
  }     
  .booked {
    background-color: yellow; 
    color: black;
  }
  .buying {
    background-color: orange; 
    color: #fff;
  }
  .confirmed {
    background-color: red;
    color: #fff;
  }
  .empty {
    background-color: white;
    border-width: 0;
      /*color: #0a0a0a;*/
    color:white;        
  }
  
  .search-form {
    .input-group-text i {
      color: #a0cc59;
    }
  } 
  .warning-l {
    background-color: #FFE006;
    border-radius: 0.25rem 0 0 0.25rem;
    color: #FAB005;
    text-align: center;
  }
  .warning-r {
    background-color: #fff9db;
    border-radius: 0 0.25rem 0.25rem 0;
    //color: #FAB005;
    //text-align: center;
  }
  .info-l {
    color: #0c5460;
    background-color: #bee5eb; //#d1ecf1;
    border-radius: 0.25rem 0 0 0.25rem;
    text-align: center;
  }
  .info-r {
    background-color: #d1ecf1;
    border-radius: 0 0.25rem 0.25rem 0;
    //color: #FAB005;
    //text-align: center;
  }    
/* end seat display */

.modal-width {
  max-width: 370px;
}

.info-scroll {
  max-height: 25rem;
  overflow-y: auto;
}

  // Small devices (landscape phones, 576px and up)
  @media (min-width: 576px) { 
    .modal-width {
      max-width: 400px;
    }    
    // .info-scroll {
    //   max-height: 350px;
    // }
  }

  // Medium devices (tablets, 768px and up)
  @media (min-width: 768px) {
    .modal-width {
      max-width: 500px;
    }    
  } 
  
  // Large devices (desktops, 992px and up)
  @media (min-width: 992px) {
    .modal-width {
      max-width: 660px;
    }
  }

  // Extra large devices (large desktops, 1200px and up)
  @media (min-width: 1200px) {
    .modal-width {
      max-width: 760px;
    }
  }

  .info-table {
    background-color: hsla(60, 56%, 91%, 1);
    // max-height: 350px;
    // :deep(.info-table-top) {
    //   border-top-left-radius: 4px;
    //   border-top-right-radius: 4px;
    //   height: 1rem;
    // }
    :deep(.info-table-left) {
      background-color: hsla(60, 68%, 88%, 1); 
      // border-right: 1px solid hsla(210, 23%, 89%, 1) !important;
      border-right: 1px solid hsla(66, 45%, 80%, 1) !important;
    }
    :deep(.filter-title) {
    // color: var(--dark);
    font-size: 1rem;
    font-weight: 500;
    letter-spacing: 2px;
    background-color: hsl(74, 58%, 64%);
    padding: 5px;
    border-top-left-radius: 4px;
    border-top-right-radius: 4px;
    text-align: center;
    } 
    :deep(.filter-element) {
      background-color: hsl(74, 46%, 81%);
      font-size: .9rem;
      padding: .5rem;
      border-bottom-left-radius: 4px;
      border-bottom-right-radius: 4px;
    }    
    :deep(.table thead th) {
      border-bottom: none;    
    }
  }
  :deep(.info-table-top) {
    border-top-left-radius: 4px;
    border-top-right-radius: 4px;
    height: 1rem;
  }
  :deep(.bg-bus) {
    position: relative;
    height: 15vh;
    width: 17vh;
  }
  :deep(.img-bus) {
    position: relative;
    height: 15vh;
    width: 17vh;
  }
  
/**** scroll bar ******/
// ::-webkit-scrollbar{
//     width: 10px;
//     height: 10px;
//     padding-top: 40px;
// }

// ::-webkit-scrollbar-track{
//     -webkit-box-shadow: inset 0 0 1px rgba(0,0,0,0.3);
//     border: 1px solid black;
//     background: rgb(41,41,41);
//     border-radius: 10px;

// }
// ::-webkit-scrollbar-thumb{
//     border-radius:10px;
//     height: 30px;
//     width: 8px;
//     border: 1px solid black;
//     background: rgb(111,111,111);
//     -webkit-box-shadow: 0 1px 1px rgb(0,0,0);
//     background: -webkit-linear-gradient(rgb(200,200,200), rgb(150,150,150));
// }

// ::-webkit-scrollbar-track-piece {
//     height: 30px;
//     width: 30px;
// }

/* Works on Firefox */
* {
  scrollbar-width: thin;
  scrollbar-color: blue orange;
}

// /* Works on Chrome, Edge, and Safari */
// *::-webkit-scrollbar {
//   width: 10px;
// }

// *::-webkit-scrollbar-track {
//   background: orange;
// }

// *::-webkit-scrollbar-thumb {
//   background-color: blue;
//   border-radius: 20px;
//   border: 3px solid orange;
// }
::-webkit-scrollbar-track
{
  -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3);
  background-color: #F5F5F5;
  border-radius: 10px;
}

::-webkit-scrollbar
{
  width: 10px;
  background-color: #F5F5F5;
}

::-webkit-scrollbar-thumb
{
  border-radius: 10px;
  background-image: -webkit-gradient(linear,
                     left bottom,
                     left top,
                     color-stop(0.44, rgb(122,153,217)),
                     color-stop(0.72, rgb(73,125,189)),
                     color-stop(0.86, rgb(28,58,148)));
}
</style>
