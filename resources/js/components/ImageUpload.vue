<template>
	<div class="d-flex">	    
		<!-- <div class="form-group col-6"> -->
		<div class="p-2">
		  <div class="card">
		      <div class="card-header bg-secondary">
		      	<span class="image-box">
		      		<i class="far fa-images"></i>	      		
		      	</span>
		      	Image Uploader
		      </div>
			  <div class="card-body">
			  	<div class="form-group">
			        <label for="title">Title</label>
			        <input type="text" name="title" class="form-control" :class="{ 'is-invalid': has('title') }" id="title" placeholder="Enter Image Title" v-model="formData.title">
			        <span class="invalid-feedback" v-if="has('title')" v-text="get('title')">
		            </span>
			    </div>
			    <!-- <div class="input-group">
				  <div class="custom-file">
				    <input type="file" class="custom-file-input form-control" :class="{ 'is-invalid': has('image') }" id="inputGroupFileimage" aria-describedby="inputGroupFileAddon04" @change="onFileChange">
				    <span class="invalid-feedback" v-if="has('image')" v-text="get('image')">
		            </span>
				    <label class="custom-file-label" for="inputGroupFileimage">Choose file</label>
				  </div>
				  <div class="input-group-append">
				    <button class="btn btn-outline-secondary" type="button" id="inputGroupFileAddon04" @click.prevent="upload()">Upload</button>
				  </div>
				</div> -->
				<div class="form-group">
			        <label for="image">Image</label>
			        <input type="file" name="image" class="form-control-file" :class="{ 'is-invalid': has('image') }" id="image" @change="onFileChange">
			        <span class="invalid-feedback" v-if="has('image')" v-text="get('image')">
		            </span>
				</div>
				<div class="my-3">		  	
				  <img :src="imagePreview" width="100" height="100" v-show="showPreview"/>
			    </div>
				<div class="form-group">
		        	<button type="button" class="btn btn-success mr-2" @click.prevent="upload()">Upload
		        	</button>
		        	<button type="button" class="btn btn-warning" @click.prevent="reset()" :disabled="!isValid">Cancel
		        	</button> 
			    </div>
			  </div>
			</div>	
		</div>

		<!-- <div class="form-group col-6" v-show="isImageAvailable"> -->
		<div class="p-2" v-show="isImageAvailable">
      <div class="card">
        <div class="card-body p-0">
          <table class="table">
            <thead class="thead-light">
              <tr>
                <th scope="col">#</th>
                <th scope="col">Image</th>
                <th scope="col">Title</th>
                <th scope="col">Action</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(image, index) in images">
                <th scope="row">{{index+1}}</th>
                <td>
                  <img :src="url(image)" width="100" height="100" />
                </td>
                <td>
                  {{image.title}}
                </td>
                <td>
                  <button @click.prevent="remove(image)" class="btn btn-outline-danger">
                  <i class="far fa-trash-alt mr-2"></i>Remove
                </button> 
                </td>
              </tr>    
            </tbody>
          </table>                        
        </div>
      </div>
    </div>                      
		
  </div>
</template>	

<script>    
    export default {
    	props: ['directory', 'saved', 'maxNumberOfImages'],
      data() {
	      return {
	      	errors: {},
	      	images: [],
	      	formData: {
	            image: null,
	            title: ''
	      	},
	        imagePreview: null,
			showPreview: false,
			// message: '',
        }
      },
        mounted() {
            console.log('Image Upload Component mounted.')
        }, 
        watch: {
        	saved(value) {
        		if(value === true) {
        			this.emptyImagesArray();        			
        		}
        	},
        },
        computed: {
        	isImageAvailable() {
            return (this.images.length > 0) ? true : false;
          },
          isValid() {            
            return this.formData.image !== null ||
            			this.formData.title !== '';
          },
        },
        methods: {
        	actionAlert(icon, message) {
		        swal({           
		          title: 'Image Upload',
		          text: `${message}`,
		          icon: icon,
		          timer: 3000,
		          closeOnClickOutside: false,
		        })
	      	},
	      	emptyImagesArray() {
	      		this.images = [];
	      	},
        	onFileChange(event) {
				    this.formData.image = event.target.files[0];
				    // console.log(this.formData.image)

				    this.handleImagePreview();			    
					},
					handleImagePreview() {
						/*
					    Initialize a File Reader object
					    */
					    let reader  = new FileReader();

					    /*
					    Add an event listener to the reader that when the file
					    has been loaded, we flag the show preview as true and set the
					    image to be what was read from the reader.
					    */
					    reader.addEventListener("load", function () {
					        this.showPreview = true;
					        this.imagePreview = reader.result;
					    }.bind(this), false);

					    /*
					    Check to see if the file is not empty.
					    */
					    if(this.formData.image){
					        /*
					            Ensure the file is an image file.
					        */
					        if ( /\.(jpe?g|png|gif)$/i.test(this.formData.image.name) ) {

					            console.log("here");
					            /*
					            Fire the readAsDataURL method which will read the file in and
					            upon completion fire a 'load' event which we will listen to and
					            display the image in the preview.
					            */
					            reader.readAsDataURL(this.formData.image);
					        }
					    }
					},
        	upload() {
        		let formData = new FormData();
        		formData.append('image', this.formData.image);
        		formData.append('title', this.formData.title);
        		formData.append('directory', this.directory);

        		if(this.maxNumberOfImages) {
        			if(! (this.images.length < this.maxNumberOfImages) ) {
        				let message = `Sorry! You cann't upload more than ${this.maxNumberOfImages} at a time.`;
        				this.actionAlert('warning', message);
        				return;	
        			}
        		}

        		axios.post('/images', formData)
        		.then((response) => {
        			console.log(response.data);
        			this.actionAlert('success', response.data.message);
        			this.reset();
        			let image = this.dispatchEventUploaded(response.data);
              		this.addToImagesArray(image);
        		})
        		.catch((error) => {
        			console.log(error.response.data);
        			this.errors = error.response.data.errors;
        		});
        	},

        	dispatchEventUploaded(data) {        	
            let image = {
              title: data.title,
              name: data.name,
              path: data.path,
            }
            this.$emit('uploaded', image);
            return image;
          },          
          addToImagesArray(image) {
            this.images.push(image);            	
        	},
        	url(image) {
            let path = image.path;
            return `/storage/${path}`;
          },
          remove(image) {
          	axios.delete('/images/delete', {data: {path: image.path}})
		      		.then((response) => {
		      			// console.log(response.data);
		      			this.actionAlert('success', response.data.message);
		      			// this.reset();
		      			this.dispatchEventRemoved(image);
		            this.removeFromImagesArray(image);
		      		})
		      		.catch((error) => {
		      			// console.log(error.response.data);
		      			this.errors = error.response.data.errors;
		      		});
          },
          dispatchEventRemoved(image) {
            this.$emit('removed', image);
          },
        	removeFromImagesArray(image) {
        		let index = this.images.indexOf(image);
        		// console.log('iupIndx', index);
        		this.images.splice(index, 1);
        	},
        	reset() {
        		// this.formData.image = null;
        		this.formData = {
	                image: null,
	                title: ''
            	};
            	this.imagePreview = null;
            	this.showPreview = false;
            	this.errors = {};
            	// this.images = [];
        	},

        	has(field) {
		        return this.errors.hasOwnProperty(field);
		    },   

		    get(field) {		    	
		         if (this.errors[field]) {
		            return this.errors[field][0];
		        }
		    }
        }
    }
</script>
<style lang="scss" scoped>
	.image-box {
		margin-right: 5px; 
	    padding: 3px 5px 3px 5px;
	    background-color: #dee2e6;
	    border-radius: 4px;
	    color: #212529;
	}	
</style>