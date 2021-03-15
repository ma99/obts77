<template>
<!-- Progress Tracker -->
      <div class="row no-gutters progressbar mx-auto my-3 text-center">
        <!-- <ul class="text-center"> -->
          <div class="col-4 position-relative">
            <div class="shape-outer rhombus">
              <i class="fas fa-search fa-3x progress-icon"></i>
            </div>
            
            <!-- <div class="mt-3 mb-1 mx-auto action">               -->
              <!-- <i class="fas fa-check my-3 action first done" -->
              <i                
                :class="['fas',                    
                  { 'fa-times': search.default },
                  { 'fa-sync': search.isDoing },
                  { 'fa-check': search.isDone }, 
                  { doing: search.isDoing },
                  { done: search.isDone },
                  'my-3', 'action', 'first'
                ]"                
              ></i>            
            <!-- </div> -->
            <p>Search</p>
          </div>
          <div class="col-4 position-relative">
            <div class="shape-outer rhombus">
              <i class="fas fa-hand-pointer fa-3x progress-icon"></i>            
            </div>
            <!-- :class="{ doing: steps.select.isDoing }"
            :class="{ done: steps.select.isDone }" -->
            <!-- <span class="mt-3 mb-1 mx-auto action">               -->
              <!-- <i class="fas fa-sync my-3 action doing" -->
              <i 
                :class="['fas',                    
                  { 'fa-times': select.default },
                  { 'fa-sync': select.isDoing },
                  { 'fa-check': select.isDone }, 
                  { doing: select.isDoing },
                  { done: select.isDone },
                  'my-3', 'action'
                ]"                
              ></i>            
            <!-- </span> -->
            <p>Select</p>
          </div>
          <div class="col-4 position-relative">
            <div class="shape-outer rhombus">
              <i class="fas fa-wallet fa-3x progress-icon"></i>            
            </div>                
            <i 
              :class="['fas',                    
                { 'fa-times': buy.default },
                { 'fa-sync': buy.isDoing },
                { 'fa-check': buy.isDone }, 
                { doing: buy.isDoing },
                { done: buy.isDone },
                'my-3', 'action', 'last'
              ]"                
            ></i>            
            <!-- </span> -->
            <p>Buy</p>
          </div>
        <!-- </ul> -->
      </div>
    <!-- // -->
</template>

<script>
    
    export default {
        props: {
            search: Object,
            select: Object,
            buy: Object
        },
        
        data() {
            return {
                msg: 'Hello',
                number: 2
            }
        },
        mounted() {
            console.log('Component mounted.')
        },
        computed: {

        },
        methods: {
        }
    }
</script>
<style lang="scss">
    // progressbar
.shape-outer {
    display: flex;
    flex-shrink: 0;
    height: calc(70px + 4vw);
    width: calc(70px + 4vw);
    margin: 0 auto;
    // background-image: linear-gradient(to bottom right, #ff3cac, #562b7c, #2b86c5);
    background-image: linear-gradient(to bottom right, var(--warning), hsl(162deg 87% 74%), hsl(205deg 64% 47%));    
  }

  .rhombus {
    -webkit-clip-path: polygon(50% 0%, 100% 50%, 50% 100%, 0% 50%);
        clip-path: polygon(50% 0%, 100% 50%, 50% 100%, 0% 50%);
  }



  .progressbar {
    // ul li { 
    //   display: inline-block;
    //   width: 12.5rem;
    //   position: relative;

      i.progress-icon {
        // color: green;
        margin: auto;
      }
      
      i.action {
        background-color: #ccc;
        border-radius: 50%;
        color: #fff;
        font-size: small;
        padding: 0.375rem;
        height: 1.5rem;
        width: 1.5rem;
      }

      i.action::after {
        background-color: #ccc;
        content: '';
        height: 0.3125rem;
        width: 100%; //12.5rem;
        display: block;
        position: absolute;
        left: 0;
        top: calc(58% + 1vh); //110px; //4.6875rem;
        z-index: -1;
      }

      i.doing {
        background-color: #148e14;
      }   
      i.doing::after {
        background-color: #148e14;
      }

      i.done {
        background-color: hsla(45, 100%, 51%, 1);
      }   
      i.done::after {
        background-color: hsla(45, 100%, 51%, 1);
      }

      .first::after {
        left: 50% !important; //6.35rem
        width: 100% !important;
      }
      .last::after {
        width: 50% !important;
      }

    // }
  }
//

  // Small devices (landscape phones, 576px and up)
  @media (min-width: 576px) {     
    i.action::after {        
      top: calc(61% + 1vh) !important; //110px; //4.6875rem;
    }

  }

  // Medium devices (tablets, 768px and up)
  @media (min-width: 768px) {    
    i.action::after {        
      top: calc(62% + 1vh) !important; //110px; //4.6875rem;
    }

  } 
  
  // Large devices (desktops, 992px and up)
  @media (min-width: 992px) {
    
    i.action::after {        
      top: calc(63% + 1vh) !important; //110px; //4.6875rem;
    }

  }

  // Extra large devices (large desktops, 1200px and up)
  @media (min-width: 1200px) {    
    i.action::after {        
      top: calc(67% + 1vh) !important; //110px; //4.6875rem;
    }

  }
</style>