<script setup>
    import { useRouter } from "vue-router"
    import { onMounted, ref } from "vue"
    import axios from "axios"
    
    const router = useRouter()
    
    const types = ref([])
    const loading = ref(false)
    
    onMounted(() => {
        getTypes()
    })
    
    const getTypes = async () => {
        loading.value = true
        try {
            const res = await axios.get("/api/types")
            types.value = res.data.types
        } finally {
            loading.value = false
        }
    }
    
    const createType = () => {
        router.push("/types/create")
    }
    
    const editType = (id) => {
        router.push(`/types/${id}/edit`)
    }
    
    const deleteType = (id) => {
        Swal.fire({
            title: "Are you sure?",
            icon: "warning",
            showCancelButton: true,
        }).then(async (result) => {
            if (result.isConfirmed) {
                await axios.delete(`/api/types/${id}`)
                getTypes()
            }
        })
    }
    </script>
    
    <template>
        <div class="container-fluid mt-5">
            <div class="card">
                <div class="card-body">
    
                    <div class="d-flex align-items-center mb-3">
                        <h5 class="mb-0">All Types</h5>
                        <button
                            class="btn btn-success ms-auto"
                            @click="createType"
                            :disabled="loading"
                        >
                            Add Type
                        </button>
                    </div>
    
                    <div v-if="loading" class="text-center py-5">
                        <div class="spinner-border text-primary"></div>
                    </div>
    
                    <div v-else class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Category</th>
                                    <th>Type</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
    
                            <tbody>
                                <tr v-for="type in types" :key="type.id">
                                    <td>{{ type.category.category }}</td>
                                    <td>{{ type.type }}</td>
                                    <td>
                                        <button
                                            class="btn btn-sm btn-primary me-2"
                                            @click="editType(type.id)"
                                        >
                                            Edit
                                        </button>
    
                                        <button
                                            class="btn btn-sm btn-danger"
                                            @click="deleteType(type.id)"
                                        >
                                            Delete
                                        </button>
                                    </td>
                                </tr>
    
                                <tr v-if="types.length === 0">
                                    <td colspan="3" class="text-center">
                                        No types found
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
    
                </div>
            </div>
        </div>
    </template>
    