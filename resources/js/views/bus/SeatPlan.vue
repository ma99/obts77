<template>
  <div class="content-wrapper">    
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Seat Plan</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item">
                <router-link :to="{ name: 'dashboard' }">
                  <i class="fa fa-tachometer nav-icon"></i> Dashboard
                </router-link>
              </li>
              <li class="breadcrumb-item active">Seat Plan</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>

    <section class="content">
      <div class="container-fluid">
        <add-section :show.sync="show">
          <template v-slot:heading>
            <header-icon 
              icon-inner="fa-couch" 
              icon-outer="fa-circle" 
              icon-color="hsla(123, 38%, 64%, .8)"
              text-color="hsla(123, 52%, 52%, 1)"
              :shadow="true"
            >
              Add Seat Plan
            </header-icon>              
          </template>
          <form> 
            <box                   
              background-color="hsla(88, 60%, 87%, 1)" 
              border-radius=".5"
              :margin='{top: 1.25, bottom: 1.25}'
              heading-background="hsla(89, 80%, 90%, 1)" 
              heading-border-radius="5"
              heading-width="11.25" 
              heading-show="true"
              :shadow="true"
            >
              <template v-slot:heading>Seat Plan</template>

              <div class="form-row justify-content-center">
                  
                <div class="col-sm-2">
                  <div class="form-group">
                    <label for="numberOfCol">Column #</label>
                    <input v-model="numberOfCol" type="number" min="1" max="4" class="form-control" id="numberOfCol" placeholder="Column Number" disabled>
                  </div>
                </div>
                  
                <div class="col-sm-2">
                  <div class="form-group">
                    <label for="numberOfRow">Row #</label>
                    <input v-model="numberOfRow" type="number" min="1" max="25" class="form-control" id="numberOfRow" placeholder="Row Number" :disabled="isDisabled">
                  </div>
                </div>

                <div class="col-sm-6">
                  <div class="button-group">                        
                    <button v-on:click.prevent="createList()" class="btn btn-info mr-2" v-show="!showSeatPlan" :disabled="!isValidForShow">
                      <i class="far fa-eye mr-2"></i>Show
                    </button>                  

                    <button class="btn btn-secondary mr-2" @click.prevent="hideSeatPlan()" v-show="showSeatPlan" :disabled="!isValidForShow">
                      <i class="far fa-eye-slash mr-2"></i>Hide
                    </button>                  
                    
                    <button v-on:click.prevent="saveSeatList()" class="btn btn-primary mr-2 px-5" :disabled="!showSeatPlan">
                      <i class="far fa-save mr-2"></i>Save
                    </button>

                    <button v-on:click.prevent="reset()" class="btn btn-warning">
                      <i class="far fa-window-close mr-2"></i>
                    Reset
                    </button>                    

                  </div>
                </div>  
              </div>

            </box>
          </form>  
        </add-section>        
        
        <show-alert :show.sync="showAlert" :type="alertType"> 
          <strong> Seat Plan </strong> has been <strong>{{ actionStatus }} </strong>
        </show-alert>

        <app-modal modal-id="seatplan">
          <seat-layout :seatList="selectedSeatPlan" />
        </app-modal>         
        
        <error-modal modal-id="error" :error-list="errorList" />

        <loader :show="loading"></loader>

        <div class="row" v-show="showSeatPlan">
          <div class="card card-outline card-info">
            <div class="card-header">
              Seat Plan
            </div>
            <div class="card-body">                
              <div class="seat-layout-design">
                <div class="row">
                  <div class="combine mt-3">                    
                    <div class="form-check">                      
                      <input class="form-check-input" type="checkbox" id="defaultCheck1" v-model="combineType">
                      <label class="form-check-label" for="defaultCheck1">
                        Combined Type Seat Plan
                      </label>
                    </div>
                  </div>                  
                </div>
                <div class="row driver-seat">                      
                  <button type="button" class="btn" :disabled="true">
                    <i class="fas fa-peace fa-lg"></i>
                  </button>                      
                </div>

                <div id="design" class="row justify-content-center">
                  <div class="col-xs-2" 
                    v-bind:class="{ 'col-xs-offset-2': emptySpace(index, seat.no) }"
                    v-for="(seat, index) in seatList"
                  >
                    <input class="mr-2" type="checkbox" :id="'checkbox-'+index" v-model="seat.special" v-show="combineType" :disabled="seat.status !='available'">                  
                    <button type="button"                                                      
                        v-bind:class="{ 
                          'btn btn-success regular' : seat.checked, 
                          'btn btn-warning' : !seat.checked, 
                          'btn special': seat.special,
                                // 'col-xs-offset-2': emptySpace(index, seat.no)
                        }"                      
                        @click="toggle(seat)"                      
                    >                       
                        <i class="fas fa-check fa-sm mr-1" v-show="seat.checked"></i>
                        <i class="fas fa-times fa-sm mr-1 crossmark" aria-hidden="true" v-show="!seat.checked"></i>

                        <!-- {{ seat.no }} - {{ seat.sts }} : {{index}}  -->
                        {{ seat.no }}                                            
                    </button> 
                  </div>
                </div>
              </div>                   
            </div>        
            <div class="card-footer">
              <h5 class="px-1"> 
                {{ totalSeats }} 
                <small class="text-muted"> seats included.</small>
              </h5>          
            </div>    
          </div>              
        </div>

        <div class="row justify-content-center py-3">          
          <div class="card w-100">
                <!-- <div class="card-header">Seat Plan Info 
                  <span class="float-right">
                    <high-light 
                      color="hsla(210, 9%, 30%, 1)" 
                      value="5"
                      :shadow="true"
                    >
                      {{ availableSeatPlanList.length }}
                    </high-light>
                  </span>
                </div> -->
                <div class="card-body p-0">
                    <div class="scrollbar">
                      <table class="table table-striped table-hover">
                          <thead class="bg-secondary">
                            <tr>
                              <th>Sl. No.</th>
                              <th>Seat Plan ID</th>         
                              <th>Total Seats
                                <span type="button" @click="sortByIdOf('totalSeats')" :disabled="!disableSorting">
                                  <i class="fa fa-sort-amount-asc" aria-hidden="true"></i>
                                </span>
                              </th>
                              <th>Created On
                                <span type="button" @click="sortByIdOf('dateCreated')" :disabled="disableSorting">
                                  <i class="fa fa-sort-amount-asc" aria-hidden="true"></i>
                                </span>
                              </th>
                              <th>Action</th>                                                         
                              <!-- <th>&nbsp;</th> -->
                            </tr>
                          </thead>
                          <tbody>
                            <tr  v-for="(seatplan, index) in availableSeatPlanList" >                              
                              <td>{{ index+1 }}</td>                              
                              <td>{{ seatplan.id }}</td>
                              <td>{{ seatplan.total_seats }}</td>
                              <td>{{ dateCreated(seatplan.created_at) }}</td>
                              <td>
                                  <!-- <button v-on:click.prevent="view(seatplan)" class="btn btn-success"> -->
                                  <button type="button" class="btn btn-outline-primary mr-2" data-toggle="modal" data-target="#modalComponent" v-on:click.prevent="view(seatplan)">    
                                    <i class="button-icon far fa-eye"></i>View
                                  </button>   
                                  <!-- <button v-on:click.prevent="edit(seatplan)" class="btn btn-primary">
                                    <i class="fa fa-edit fa-fw"></i>Edit
                                  </button>   -->
                                  <button v-on:click.prevent="remove(seatplan)" class="btn btn-outline-danger">
                                    <i class="button-icon far fa-trash-alt"></i>Remove
                                  </button> 
                              </td>                        
                            </tr>                            
                          </tbody>
                      </table>      
                    </div>
                </div>
                <div class="card-footer">
                  <h5 class="px-1"> 
                    {{ availableSeatPlanList.length }} 
                    <small class="text-muted"> seatplans available.</small>
                  </h5>          
                </div>          
          </div>
        </div>
      </div>            
    </section>        
  </div>      
</template>
<script>
      import { mapState, mapGetters, mapActions } from 'vuex';

      import AppModal from '../../components/AppModal';
      import Box from '../../components/Box';  
      import ErrorModal from '../../components/ErrorModal';  
      import SeatLayout from '../../components/SeatLayout';  
  


    export default { 
      props: {
          token: String,
      },
      components: {
          'app-modal': AppModal,
          'error-modal': ErrorModal,
          'seat-layout': SeatLayout,
          Box,
        },       
      data() {
                return {                    
                    actionStatus: '',
                    disableSorting: true,
                    alertType: '',
                    //availableSeatPlanList: [],
                    combineType: false,
                    disableSaveButton: true,
                    disableShowButton: false,
                    // error: '',
                    errorList: [],
                    numberOfCol: 4,                            
                    numberOfRow: 4,                            
                    response: '',
                    seatChar:["A","B", "C" , "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O"],
                    seatList: [],
                    seatListC4ned: [],                    
                    seatListLength: '',
                    selectedSeatPlan: [],      
                    show: false,                              
                    showSeatPlan: false,
                    showAlert: false,              
                    isDisabled: false,
                    index: 2, // empty space strating for this index then index+4
                    indexList: [],
                    instanceOfScrollbar: undefined,
                    loading: false,
                    fiveColValue: '',
                    // modal: false,
                    totalSeats: '',
                }

      },
      async mounted() {
          this.loading = true;
          this.createIndexList();
          await this.getSeatPlans({token: this.token});
          this.loading = false;
          
          if (this.any(this.errors)) {
            this.setListOf(this.errors, this.errorList)
          }

          this.enableScroll();
      },
      beforeUnmount() {
          this.instanceOfScrollbar.destroy();
          this.resetErrors();
      },
      watch: {
          numberOfRow() {
              this.createIndexList();
              this.isShowButtonDisable();                        
          },

          response() {
            //this.availableSeatPlanList.push(this.response);
            this.hideAlert();
          },
          seatList: {
            handler(val, oldVal) {
              this.totalSeatsCount(this.seatList);                               
            },
            deep: true
          },      

          success() {
              if (this.success) {
                  this.loading = false;
                  this.actionAlert(this.routeName);
                  this.reset();
                  // this.resetErrors();
                  this.setSuccess({ status: false });
              }
          },
          errors: {
             handler(value){
              this.loading = false
             },
             deep: true
          }         
      },

      computed: {
          ...mapState([
              'errors',
              'success'
          ]),
          ...mapGetters([
              'get',
              'has',
              'any'
          ]),
          ...mapState('seatplan', [
            'availableSeatPlanList',
          ]),
          ...mapGetters('seatplan', [
              'getSeatPlanBy'
          ]),

          isValidForShow() {                        
              return  this.numberOfRow != '' 
                // &&
                //       this.disableShowButton != true
            },

          isValidForSave() {                        
            return  this.numberOfRow != '' &&
                    this.disableSaveButton != true
          },        
          // status() {                      
          //   return this.seatList.map(seat => seat.status)  //working
          // },            
      },

      methods: {          
          ...mapActions([
                'setSuccess',
                'resetErrors'
            ]),
          ...mapActions('seatplan', [
            'getSeatPlans',
            'addSeatplan',
            'deleteSeatplan',
            'updateSeatplan'
          ]),
          hideSeatPlan() {
            this.showSeatPlan = false;
            this.seatList= [];
          }, 
          actionAlert(routeName) {
              swal({           
                title: 'Seat Plan',
                text: 'Created successfully!',
                icon: "success",
                timer: 2000,
                closeOnClickOutside: false,
              });
          },
          dateCreated(dateString) {
            var date = new Date(dateString);
            return date.toLocaleDateString('en-GB');
          },
          enableScroll() {
            this.instanceOfScrollbar = OverlayScrollbars(document.getElementsByClassName("scrollbar"),
            { 
              className: "os-theme-dark",
              sizeAutoCapable: true,
              scrollbars: {
                autoHide: "never",
                clickScrolling: true
              } 
            })
          },          
          totalSeatsCount(arrayName) {
            let count=0;
            arrayName.forEach(function(seat) {
              if (seat.status === 'available') {
               count++;                         
              }
            }); 
            //console.log(count);
            this.totalSeats = count;
          },
          hideAlert() {
            let vm = this;
            setTimeout(function() { 
              vm.showAlert = false;          
            }, 3000);
          },                    
          setRowNumber() {
            let length = this.selectedSeatPlan.length-1;
            this.numberOfRow = length/4;
          },
          createIndexList() {
              this.indexList=[];
              var r;
              var numberOfRow = this.numberOfRow;
              var index = this.index;
              for ( r=1; r<numberOfRow; r++ ) { 
                  this.indexList.push(index);
                  index = index+4; 
                  //console.log('index', index);
              }
          },                  
          isShowButtonDisable() {
              this.disableShowButton = ( this.numberOfRow == '' || this.numberOfRow == 0) ? 
                                      true : false;
          },
          isSaveButtonDisable() {                       
            this.disableSaveButton = (this.seatListLength == '') ? 
                                    true : false;                    
          },
          emptySpace(index, seatNo) {  //2, 6, 10
              if ( this.isFiveCol(seatNo) ) {
                  return false; // no need empty space between columns
              }
              return this.isEmptySpaceAvailable(index);
          },                     
          isFiveCol(seatNo) {                        
              var numberOfRow = this.numberOfRow;
              var lastRowChar = this.seatChar[numberOfRow-1]; //B
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
          createList() {
              var r; //row                    
              var code = 64;
              var seatNo;
              var numberOfRow = this.numberOfRow//8;
              var numberOfCol = this.numberOfCol //4;
              for ( r=1; r<=numberOfRow; r++ ) {
                  // console.log('row=', r);
                  var c; //col                            
                  for( c=1; c<=numberOfCol; c++) {
                      seatNo = String.fromCharCode(code+r)+ c ;
                      // console.log('col=', c);
                      // console.log('seat=', seatNo); 
                      this.seatList.push({
                          no: seatNo,
                          status: 'available', 
                          checked: true,
                          special: false
                      });
                  }
              }

              // for 5th column                         
              this.fiveColValue = code+numberOfRow;
              seatNo = String.fromCharCode(code+parseInt(numberOfRow))+ c ; //64+6 + 5 E5
              this.seatList.push({
                          no: seatNo,
                          status: 'available', 
                          checked: true,
                          special: false
              }); 

              this.seatListCloned = this.cloneSeatList(); 

              this.isDisabled = true;
              this.disableShowButton = true;
              this.disableSaveButton = false;
              this.seatListLength = this.seatList.length;
              // this.showSeatPlan = true;                        
              this.showSeatPlan = !this.showSeatPlan;                        
          },                  
          
          remove(seatplan) { 
            var vm = this;
            swal({
              title: "Are you sure?",
              text: "This SEAT PLAN will be Removed!",
              icon: "error",                 
              dangerMode: true,
              buttons: {
                  cancel: "Cancel",
                  confirm: {
                    text: "Remove It!",
                    value: true,
                  },                                
              },
            })
            .then((value) => {
              if (value) {
                vm.showAlert = false;
                vm.removeSeatplanBy(seatplan.id);
              }               
            }); 
          },
          async removeSeatplanBy(id) {
            this.loading = true
            await this.deleteSeatplan(id);
            this.loading = false;
            this.actionStatus = 'Removed';
            this.alertType = 'danger';
            this.showAlert= true;
          },                  
          reset() {
              this.seatList=[];
              this.numberOfRow = '';
              this.isDisabled = false;
              //this.disableSaveButton = true;
              this.disableShowButton = true;
              this.seatListLength = '';
              this.showSeatPlan = false;

              this.resetErrors();
          },
          saveSeatList() {
            this.loading = true;

            this.addSeatplan({
                seat_list: this.seatList,
                total_seats: this.totalSeats
            });
          },
          toggle(seat) {                     
              seat.checked = !seat.checked; 
              if (seat.checked) {                          
                  seat.status = 'available';
                  this.c                          
                  this.updateSeatList(seat, 'available');                       
                  return ;
              }                                                       
              seat.status = 'n/a';                     
              this.updateSeatList(seat, 'n/a');                       
          },
          updateSeatList(seat, status) {                        
            var clonedSeatList = this.cloneSeatList();
            var index = this.seatList.indexOf(seat);                     
            var rightColIndexList = this.createIndexListOfRightMostColumn();   
            var indexExist = rightColIndexList.includes(index);                 
            
            switch (status) {
              case 'n/a':           
                if (!indexExist) {                     
                  this.seatList[index+1].no = seat.no; 
                  while (!rightColIndexList.includes(index)) {
                    //console.log('newindex='+index);                            
                    if (index == this.seatListLength-2) { 
                      return;
                    }                             
                    var seatToShift = clonedSeatList[index+1].no; 
                    var seatToBeReplaced = this.seatList[index+2].no; 

                    if (seatToShift.substring(0, 1) != seatToBeReplaced.substring(0, 1))  {
                      return;
                    }
                    this.seatList[index+2].no = seatToShift;
                    index++;                                                   
                  }
                }                        
                break;
              
              case 'available':
                let seatListCloned = this.seatListCloned; 
                var idx = this.findIndexOf(seat, seatListCloned);
                console.log('idx='+idx);                       

                while (!rightColIndexList.includes(index))  
                {  
                  //console.log('cindx='+indx);                      
                  console.log('cindx='+index);                      
                  this.seatList[index+1].no = this.seatListCloned[idx+1].no;                          
                  //this.seatList[index+1].no = this.seatListCloned[index+1].no;                          
                  index++; 
                  idx++;
                  if (index == this.seatListLength-1) { 
                    return;
                  } 
                }                        
                break;

              default:
                console.log('Sorry, we are out of ' + status + '.');
            }                    
          },
          findIndexOf(obj, arr) {
            for (let i = 0; i < arr.length; i++) {
                if (arr[i].checked == obj.checked && 
                    arr[i].no == obj.no && 
                    arr[i].status == obj.status) {
                    return i;
                }
            }
            return -1;                
          },

          createIndexListOfRightMostColumn() {
            var indexList=[];
            var r;
            var numberOfRow = this.numberOfRow;
            var index = 4;
            for ( r=1; r<=numberOfRow; r++ ) { 
                (r == numberOfRow) ?
                indexList.push(index) : indexList.push(index-1); //3 7 11 15
                index = index+4; //8 12 16
                //console.log('index', index);
            }
            //console.table(indexList);
            return indexList;
          },

          cloneSeatList() {
            return JSON.parse(JSON.stringify(this.seatList));
          },                   
          
          view(seatplan) {
            this.showSeatPlan = false;
            this.selectedSeatPlan = seatplan.seat_list;
            this.setRowNumber();
            this.createIndexList(); 
            // this.modal = true;
            this.showTheModal('seatplan')
            this.totalSeatsCount(this.selectedSeatPlan);                        
          },
          setListOf(errors, list) {
            Object.keys(errors).forEach(key => {
              list.push({
                key: key.toUpperCase(),
                value: errors[key][0]
              })
            });
            this.showTheModal('error');
          },
          showTheModal(modalId) {                  
            $(`#${modalId}`).modal({
              backdrop: 'static'
            })
          },
      }
    }
</script>
<style lang="scss" scoped>
    #design {
      .active {
        background: linear-gradient(0deg, #f4e542, #e4c25c); //#f4e542;
      }                   
      .regular i {
        color: #a5d6a7;
        //color: green;
        /*padding: 5px;*/
      }
      .special {
        background: linear-gradient(0deg, #fd7e14, #e6ceb9);
        color: black;
        border-color: white;
        i {
          color: #af8850;
        }      
      }
    }    
    .inactive {
        background-color: #c4c0c0;  
    }                           
    .crossmark {
        /*background-color: red;*/
        /*padding: 5px;*/
        color: red;
    }
    
    /*#app button {               
        height: 50px;
        margin: 10px 10px 0 0;
    }*/
    #design button { 
      padding: 0 13px 0 10px;
    }    
    #app .col-xs-2 {
      width: 16.76666667%;
    }
    #app .col-xs-offset-2 {
      margin-left: 17.666667%;
    }
    #app .button-group {
      margin: 1.9rem auto; 
    }    

    .seat-layout-design {
        background-color: #E8F5E9;        
        border: 1px solid;
        color: #4DB6AC;
    }
    .seat-layout-design, .seat-layout-display {      
      padding: 0 0 2rem 8%;                     
      button {
        height: 50px;        
        margin: 10px 10px 0 0;          
      }        
      div.row.driver-seat {        
        height: 4rem;
        position: relative;
        > button {
          position: absolute;
          top: 0;
          right: 0;
          margin: 10px 0;
          width: 65px;
          font-weight: 600;
          //background: #bdf1b2b8;
        }
      }
    } 
    .seat-layout-design div.row.driver-seat {      
      width: 82%;      
      > button {
        background: linear-gradient(90deg, #C5E1A5, #DCEDC8);
      }
    }
    .seat-layout-display div.row.driver-seat {      
      width: 100%;      
    }
  .empty {
    background-color: white;
    border-width: 0;   
    color:white;        
  }
</style>