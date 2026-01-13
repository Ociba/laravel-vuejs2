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
        category_id: "",
        type: "",
    })
    
    /**
     * UI STATE
     */
    const categories = ref([])
    const errors = ref({})
    const loading = ref(false)      // Save button loading
    const pageLoading = ref(true)   // Page/form loading
    const editMode = ref(false)
    
    /**
     * LOAD DATA
     */
    onMounted(async () => {
        pageLoading.value = true
    
        await fetchCategories()
    
        // Detect edit mode
        if (route.params.id) {
            editMode.value = true
            await fetchType()
        }
    
        pageLoading.value = false
    })
    
    /**
     * FETCH CATEGORIES FOR SELECT
     */
    const fetchCategories = async () => {
        try {
            const res = await axios.get("/api/categories")
            categories.value = res.data.categories.data || []
        } catch (error) {
            console.error("Failed to fetch categories", error)
        }
    }
    
    /**
     * FETCH TYPE (EDIT)
     */
    const fetchType = async () => {
        try {
            const res = await axios.get(`/api/types/${route.params.id}/edit`)
            form.category_id = res.data.type.category_id
            form.type = res.data.type.type
        } catch (error) {
            console.error("Failed to fetch type", error)
            // optional: redirect back if not found
            router.push("/types")
        }
    }
    
    /**
     * SAVE HANDLER
     */
    const handleSave = () => {
        editMode.value ? updateType() : createType()
    }
    
    /**
     * CREATE
     */
    const createType = async () => {
        loading.value = true
        errors.value = {}
    
        try {
            await axios.post("/api/types", form)
            toast.fire({ icon: "success", title: "Type Created" })
            router.push("/types")
        } catch (e) {
            if (e.response?.status === 422) {
                errors.value = e.response.data.errors
            }
        } finally {
            loading.value = false
        }
    }
    
    /**
     * UPDATE
     */
    const updateType = async () => {
        loading.value = true
        errors.value = {}
    
        try {
            await axios.put(`/api/types/${route.params.id}`, form)
            toast.fire({ icon: "success", title: "Type Updated" })
            router.push("/types")
        } catch (e) {
            if (e.response?.status === 422) {
                errors.value = e.response.data.errors
            }
        } finally {
            loading.value = false
        }
    }
    </script>
    
    <template>
    <div class="container-fluid mt-5">
        <div class="col-sm-8 m-auto">
            <div class="card">
                <div class="card-body">
    
                    <!-- PAGE LOADING -->
                    <div v-if="pageLoading" class="d-flex justify-content-center py-5">
                        <div class="spinner-border text-primary" role="status"></div>
                    </div>
    
                    <!-- FORM -->
                    <template v-else>
                        <h5 class="mb-4">{{ editMode ? "Edit Type" : "Create Type" }}</h5>
    
                        <!-- CATEGORY -->
                        <div class="mb-4">
                            <label class="form-label">Category</label>
                            <select class="form-select" v-model="form.category_id">
                                <option value="">Select Category</option>
                                <option v-for="cat in categories" :key="cat.id" :value="cat.id">
                                    {{ cat.category }}
                                </option>
                            </select>
                            <small v-if="errors.category_id" class="text-danger">
                                {{ errors.category_id[0] }}
                            </small>
                        </div>
    
                        <!-- TYPE -->
                        <div class="mb-4">
                            <label class="form-label">Type</label>
                            <input type="text" class="form-control" v-model="form.type" />
                            <small v-if="errors.type" class="text-danger">
                                {{ errors.type[0] }}
                            </small>
                        </div>
    
                        <!-- ACTIONS -->
                        <div class="d-flex gap-2">
                            <button class="btn btn-outline-secondary" @click="router.push('/types')">
                                Back
                            </button>

                            <button class="btn btn-dark" :disabled="loading" @click="handleSave">
                                {{ loading ? (editMode ? "Updating..." : "Saving...") : (editMode ? "Update Type" : "Save Type") }}
                            </button>
                        </div>

                    </template>
    
                </div>
            </div>
        </div>
    </div>
</template>
    