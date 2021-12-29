<template>
	<div>	    
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
	        	<button type="button" class="btn btn-warning" @click.prevent="reset()">Reset
	        	</button> 
		    </div>
		  </div>
		</div>	    
    </div>
</template>	

<script>    
    export default {
    	props: ['directory'],
        data() {
            return {
            	errors: {},
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
        	onFileChange(event) {
			    this.formData.image = event.target.files[0];
			    console.log(this.formData.image)

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
        		
        		axios.post('/images', formData)
        		.then((response) => {
        			console.log(response.data);
        			this.actionAlert('success', response.data.message);
        			this.reset();
        			this.$emit('uploaded', response.data);
        		})
        		.catch((error) => {
        			console.log(error.response.data);
        			this.errors = error.response.data.errors;
        		});
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