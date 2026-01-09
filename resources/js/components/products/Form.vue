<script setup>
    import { reactive, ref, computed } from "vue"
    import { useRouter } from "vue-router"
    
    const form = reactive({
        item_name: "",
        discount: "",
        description: "",
        price: "",
        condition: "",
        image: ""
    })
    
    const router = useRouter()
    
    const errors = ref({})
    const loading = ref(false)
    
    // Computed property to check if we should show the image
    const showImage = computed(() => {
        return form.image && form.image.length > 0
    })
    
    const getImage = () => {
        if(form.image){
            if(form.image.indexOf("base64") !== -1){
                return form.image
            } else if(form.image) {
                return "/upload/" + form.image
            }
        }
        return "" // Return empty string if no image
    }
    
    const handleFileChange = (e) => {
        let file = e.target.files[0]
        if(file){
            let reader = new FileReader()
            reader.onloadend = () => {
                form.image = reader.result
            }
            reader.readAsDataURL(file)
        } else {
            form.image = "" // Clear image if no file selected
        }
    }
    
    const handleSave = async () => {
        loading.value = true
        errors.value = {}
    
        try {
            const response = await axios.post('/api/products', form)
    
            if (response.data.success) {
                toast.fire({icon:"success", title:"Product Added Successfully"})
                // Reset form
                Object.keys(form).forEach(key => {
                   form[key] = ""
                })
                
                // Redirect to home page
                router.push("/")
            }
    
        } catch (error) {
            if (error.response && error.response.status === 422) {
                errors.value = error.response.data.errors
            } else {
                alert('An error occurred. Please try again.')
                console.error(error)
            }
        } finally {
            loading.value = false
        }
    }
    
    </script>
    
    <template>
        <div class="row mt-4">
            <div class="col-lg-2 col-2"></div>
            <div class="col-lg-8 col-8">
                <h1>Create Product</h1>
                <!-- card -->
                <div class="card mb-6 shadow border-0">
                    <!-- card body -->
                    <div class="card-body p-6">
                        <div class="row">
                            <div class="row">
                                <!-- Item Name -->
                                <div class="mb-3 col-lg-6">
                                    <label class="form-label">
                                        <span class="text-danger font-weight-bold">*</span> Item Name
                                    </label>
                                    <input 
                                        type="text" 
                                        v-model="form.item_name" 
                                        class="form-control" 
                                        :class="{ 'is-invalid': errors.item_name }"
                                        placeholder="Item Name"
                                    />
                                    <div v-if="errors.item_name" class="invalid-feedback">
                                        {{ errors.item_name[0] }}
                                    </div>
                                </div>
    
                                <!-- Discount -->
                                <div class="mb-3 col-lg-6">
                                    <label class="form-label">Discount (%)</label>
                                    <input 
                                        type="number" 
                                        v-model="form.discount" 
                                        class="form-control" 
                                        :class="{ 'is-invalid': errors.discount }"
                                        placeholder="0-100"
                                        min="0"
                                        max="100"
                                    />
                                    <div v-if="errors.discount" class="invalid-feedback">
                                        {{ errors.discount[0] }}
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <!-- Price -->
                                <div class="mb-3 col-lg-6">
                                    <label class="form-label">
                                        <span class="text-danger font-weight-bold">*</span> Price
                                    </label>
                                    <input 
                                        type="number" 
                                        v-model="form.price" 
                                        class="form-control" 
                                        :class="{ 'is-invalid': errors.price }"
                                        placeholder="Price"
                                        min="0"
                                        step="0.01"
                                    />
                                    <div v-if="errors.price" class="invalid-feedback">
                                        {{ errors.price[0] }}
                                    </div>
                                </div>
                                
                                <!-- Condition -->
                                <div class="mb-3 col-lg-6">
                                    <label class="form-label">
                                        <span class="text-danger font-weight-bold">*</span> Condition
                                    </label>
                                    <select 
                                        v-model="form.condition" 
                                        class="form-control"
                                        :class="{ 'is-invalid': errors.condition }"
                                    >
                                        <option value="">Select Condition</option>
                                        <option value="new">New</option>
                                        <option value="used">Used</option>
                                        <option value="refurbished">Refurbished</option>
                                    </select>
                                    <div v-if="errors.condition" class="invalid-feedback">
                                        {{ errors.condition[0] }}
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Description -->
                            <div class="mb-3 col-lg-12">
                                <label class="form-label">
                                    <span class="text-danger font-weight-bold">*</span> Description
                                </label>
                                <textarea 
                                    v-model="form.description" 
                                    class="form-control" 
                                    :class="{ 'is-invalid': errors.description }"
                                    rows="4" 
                                    placeholder="Description"
                                ></textarea>
                                <div v-if="errors.description" class="invalid-feedback">
                                    {{ errors.description[0] }}
                                </div>
                            </div>
    
                            <!-- File Upload -->
                            <div class="mb-3 col-lg-12">
                                <label class="form-label">Product Image</label>
                                <!-- Only show image if there's one selected -->
                                <img 
                                    v-if="showImage" 
                                    :src="getImage()" 
                                    alt="Product" 
                                    class="image-product mb-2" 
                                    style="max-width: 200px; display: block;"
                                />
                                <input 
                                    type="file" 
                                    @change="handleFileChange"  
                                    class="form-control"
                                    accept="image/*"
                                />
                                <small class="text-muted">Optional: Upload product image (JPG, PNG, etc.)</small>
                            </div>
    
                            <!-- Actions -->
                            <div class="col-lg-12 d-flex gap-2">
                                <button 
                                    @click="router.push('/')" 
                                    class="btn btn-outline-secondary"
                                >
                                    Back to Products
                                </button>
                                
                                <button 
                                    @click="handleSave" 
                                    class="btn btn-dark"
                                    :disabled="loading"
                                >
                                    <span v-if="loading">Saving...</span>
                                    <span v-else>Save Product</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-2 col-2"></div>
        </div>
    </template>
    
    <style scoped>
    .image-product {
        max-width: 200px;
        height: auto;
        border: 1px solid #ddd;
        border-radius: 4px;
        padding: 5px;
    }
    .invalid-feedback {
        display: block;
    }
    </style>