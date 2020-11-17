<template>
  <!-- Modal -->
  <div class="modal fade" :id="modalId" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="staticBackdropLabel">
              <slot name="title"></slot>
            </h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <!-- <div class="modal-body scrollbar-modal"> -->
          <div class="modal-body">
            <slot></slot>
          </div>
          <div class="modal-footer">
            <button type="button" :class="['btn', btnColor, 'rounded-pill', 'px-5']" data-dismiss="modal">Got it..</button>
            <!-- <button type="button" class="btn btn-primary">Understood</button> -->
          </div>
        </div>
      </div>
  </div>    
</template>
<script>
    export default {
      props: {
        'modal-id': String,
        'btn-color': {
          default: 'btn-primary'
        }
      },                                      
      data() {
        return {
          instanceOfScrollbar: undefined,          
        }
      },
      mounted() {
        console.log('app modal mounted');
        this.enableScroll();
      },
      // watch: {      
      // },
      computed: {
        // scrollbarModal() {   
        //   const height = (this.height == 0 ) ?      
        //               `calc(100vh - (3.5rem + 1px))` :
        //               `${this.height}px`;
        //   return {
        //     height: `${height}` //`${this.height}px`
        //   }
        // },
      },      
      methods: {
          enableScroll() {
            this.instanceOfScrollbar = OverlayScrollbars(document.getElementsByClassName("modal-dialog-scrollable"),
            { 
              className: "os-theme-dark",
              sizeAutoCapable: true,
              scrollbars: {
                autoHide: "never",
                clickScrolling: true
              } 
            })
          },
      }
    }
</script>
<style lang="scss" scoped>
    /* The Modal (background) */    
    // .scrollbar-modal {      
    //   height: calc(100vh - (3.5rem + 1px));
    // }
</style>