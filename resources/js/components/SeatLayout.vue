<template>
  <div class="row justify-content-center">
    <div class="seat-layout" ref="seatlayout">
      <div class="card w-75">
        <div class="card-header bg-primary">
          Seat Layout   
          <!-- <button @click="calculateHeight()">Calculate Height</button>        -->
        </div>
        <div class="card-body bg-skyblue">
            <div class="row driver-seat">                      
              <button class="btn btn-outline-secondary" :disabled="true">Driver</button>                      
            </div>
            <div class="row justify-content-center" style="margin-left: -5px;">
              <button
                class="btn btn-outline-primary col-xs-2"
                v-bind:class="{
                  empty: seat.status=='n/a'? true : false,                                    
                  'col-xs-offset-2': emptySpace(index, seat.no) }"
                v-for="(seat, index) in seatList"
                v-on:click.prevent=""
                :disabled="buttonIsDisabled(seat.status)"
              >               
                {{ seat.no }}
              </button> 
            </div>
          <!-- </div>   -->
        </div>
        <div class="card-footer">
          <h5 class="px-1"> 
            {{ totalSeats }} 
            <small class="text-muted"> seats total.</small>
          </h5>          
        </div>
      </div>              
    </div>  
  </div>   
</template>

<script>
    export default {
      props: ['seatList'],
      data() {
        return {                    
            numberOfCol: 4,                            
            numberOfRow: 4,                            
            seatChar:["A","B", "C" , "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O"],            
            index: 2, // empty space strating for this index then index+4
            indexList: [],                        
            totalSeats: '',
        }
      },                        
      mounted() {
          console.log('seat layout component mounted.')   
          //  this.$nextTick(() => {
          // });
      },      
      watch: {
        seatList() {
          this.setRowNumber();
          this.createIndexList();
          this.totalSeatsCount(this.seatList);          
        }
      },
      // computed: {                
      // },
      methods: {      
        // calculateHeight() {
        //   let h = this.$refs.seatlayout.getBoundingClientRect().height; 
        //   this.$emit('calculate-height', h)
        // },
        buttonIsDisabled(seatStatus) {
          return seatStatus=='n/a'? true : false
        },
        setRowNumber() {
          let length = this.seatList.length-1;
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

        totalSeatsCount(arrayName) {
          let count=0;          
          arrayName.forEach(function(seat) {
            if (seat.status === 'available') {
             count++;                         
            }
          }); 
          // console.log(count);
          this.totalSeats = count;
        },                    
      }      
    }
</script>
<style lang="scss" scoped>
    #app .seat-layout {       
        display: flex;
        flex-wrap: wrap;
        justify-content:  center;
        button {               
          // height: 34px; //50px;
          margin: 10px 10px 0 0;
          &.col-xs-2 {
            width: 15.666667%;
          }
          &.col-xs-offset-2 {
            margin-left: 17.666667%;
          }
        }   
    }
    // #app button.col-xs-2 {
    //     width: 15.666667%; //14.66666667%; //16.76666667%;
    // }
    // #app button.col-xs-offset-2 {
    //     margin-left: 17.666667%;
    // }
    div.row.driver-seat {      
      height: 4rem;
      position: relative;
    }
    div.row.driver-seat > button {
      position: absolute;
      top: 0;
      right: 10%;
    }
    .empty {
      background-color: hsl(199 94% 94%);
      border-width: 0;   
      color: hsl(199 94% 94%);        
    }        
</style>