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
          <div class="modal-body scrollbar-modal">
            <slot></slot>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-primary rounded-pill" data-dismiss="modal">Got it..</button>
            <!-- <button type="button" class="btn btn-primary">Understood</button> -->
          </div>
        </div>
      </div>
  </div>    
</template>
<script>
    export default {
      props: ['modal-id'],                        
      data() {
        return {
          instanceOfScrollbar: undefined,
        }
      },
      mounted() {
        this.enableScroll();
      },      
      methods: {
          enableScroll() {
            this.instanceOfScrollbar = OverlayScrollbars(document.getElementsByClassName("scrollbar-modal"),
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
    .scrollbar-modal {      
      height: calc(100vh - (3.5rem + 1px));
    }
</style>