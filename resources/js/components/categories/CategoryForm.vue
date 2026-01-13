<script setup>
    import { onMounted, reactive, ref } from "vue"
    import { useRouter, useRoute } from "vue-router"
    import axios from "axios"
    
    const router = useRouter()
    const route = useRoute()
    
    /**
     * FORM STATE
     */
    const form = reactive({
        category: "",
        code: "",
    })
    
    /**
     * UI STATE
     */
    const errors = ref({})
    const loading = ref(false)      // Save button loading
    const pageLoading = ref(false)  // Page/form loading
    const editMode = ref(false)
    
    /**
     * DETECT EDIT MODE SAFELY
     */
    onMounted(async () => {
        if (route.params.id) {
            editMode.value = true
            pageLoading.value = true   // 🔹 start page loading
    
            await fetchCategory()
    
            pageLoading.value = false  // 🔹 stop after fetch
        }
    })
    
    /**
     * FETCH CATEGORY FOR EDIT
     */
    const fetchCategory = async () => {
        try {
            const response = await axios.get(
                `/api/categories/${route.params.id}/edit`
            )
    
            form.category = response.data.category.category
            form.code = response.data.category.code
        } catch (error) {
            console.error("Failed to load category", error)
        }
    }
    
    /**
     * SAVE HANDLER
     */
    const handleSave = () => {
        editMode.value ? updateCategory() : createCategory()
    }
    
    /**
     * CREATE CATEGORY
     */
    const createCategory = async () => {
        loading.value = true
        errors.value = {}
    
        try {
            await axios.post("/api/categories", form)
    
            toast.fire({
                icon: "success",
                title: "Category Added Successfully",
            })
    
            router.push("/categories")
        } catch (error) {
            if (error.response?.status === 422) {
                errors.value = error.response.data.errors
            }
        } finally {
            loading.value = false
        }
    }
    
    /**
     * UPDATE CATEGORY
     */
    const updateCategory = async () => {
        loading.value = true
        errors.value = {}
    
        try {
            await axios.put(
                `/api/categories/${route.params.id}`,
                form
            )
    
            toast.fire({
                icon: "success",
                title: "Category Updated Successfully",
            })
    
            router.push("/categories")
        } catch (error) {
            if (error.response?.status === 422) {
                errors.value = error.response.data.errors
            }
        } finally {
            loading.value = false
        }
    }
    </script>
    
    <template>
        <div class="container-fluid mt-5">
            <div class="row">
                <div class="col-sm-8 m-auto">
                    <div class="card">
                        <div class="card-body">
    
                            <!-- PAGE LOADING -->
                            <div
                                v-if="pageLoading"
                                class="d-flex justify-content-center align-items-center"
                                style="min-height: 200px"
                            >
                                <div class="spinner-border text-primary" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                            </div>
    
                            <!-- FORM -->
                            <template v-else>
                                <!-- HEADER -->
                                <h5 class="mb-4">
                                    {{ editMode ? "Edit Category" : "Create Category" }}
                                </h5>
    
                                <!-- CATEGORY -->
                                <div class="mb-4 row">
                                    <label class="col-sm-3 col-form-label">
                                        Category
                                    </label>
                                    <div class="col-sm-9">
                                        <input
                                            type="text"
                                            class="form-control"
                                            v-model="form.category"
                                        />
                                        <small
                                            class="text-danger"
                                            v-if="errors.category"
                                        >
                                            {{ errors.category[0] }}
                                        </small>
                                    </div>
                                </div>
    
                                <!-- CODE -->
                                <div class="mb-4 row">
                                    <label class="col-sm-3 col-form-label">
                                        Code
                                    </label>
                                    <div class="col-sm-9">
                                        <input
                                            type="text"
                                            class="form-control"
                                            v-model="form.code"
                                        />
                                        <small
                                            class="text-danger"
                                            v-if="errors.code"
                                        >
                                            {{ errors.code[0] }}
                                        </small>
                                    </div>
                                </div>
    
                                <!-- ACTIONS -->
                                <div class="d-flex gap-2">
                                    <button
                                        class="btn btn-outline-secondary"
                                        @click="router.push('/categories')"
                                    >
                                        Back
                                    </button>
    
                                    <button
                                        class="btn btn-dark"
                                        :disabled="loading"
                                        @click="handleSave"
                                    >
                                        {{ loading ? "Saving..." : "Save Category" }}
                                    </button>
                                </div>
                            </template>
    
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </template>
    