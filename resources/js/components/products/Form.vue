<template>
    <!-- Seller Dashboard Layout -->
    <div class="seller-dashboard-layout">
        <!-- Dashboard Navbar -->
        <Navbar />

        <!-- Dashboard Layout -->
        <div class="dashboard-container">
            <!-- Sidebar -->
            <SellerSidebar />

            <!-- Main Content -->
            <div class="dashboard-main">
                <!-- Dashboard Header -->
                <div class="dashboard-header mt-5">
                    <div class="header-content">
                        <h1 class="page-title">
                            <i class="bi bi-plus-circle me-2"></i>
                            <span v-if="editMode">Edit</span>
                            <span v-else>Add</span> Product
                        </h1>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <router-link to="/dashboard/seller">Dashboard</router-link>
                                </li>
                                <li class="breadcrumb-item">
                                    <router-link to="/my-products">My Products</router-link>
                                </li>
                            </ol>
                        </nav>
                    </div>

                    <div class="header-actions">
                        <router-link to="/dashboard/seller" class="btn btn-outline-primary">
                            <i class="bi bi-arrow-left me-2"></i>Back to Products
                        </router-link>
                    </div>
                </div>

                <!-- Product Form -->
                <div class="dashboard-content">
                    <div class="row">
                        <!-- Form Column -->
                        <div class="col-lg-12">
                            <div class="card form-card shadow-sm border-0">
                                <div class="card-header bg-white border-0 py-3">
                                    <h5 class="card-title mb-0">
                                        <i class="bi bi-box-seam text-primary me-2"></i>
                                        Product Details
                                    </h5>
                                    <p class="text-muted mb-0 small">Fill in all required fields marked with *</p>
                                </div>

                                <div class="card-body">
                                    <form @submit.prevent="handleSave">
                                        <!-- Product Basic Info -->
                                        <div class="form-section mb-4">
                                            <h6 class="section-title">
                                                <i class="bi bi-info-circle me-2"></i>
                                                Basic Information
                                            </h6>
                                            <div class="row g-3">
                                                <!-- Item Name -->
                                                <div class="col-md-12">
                                                    <label class="form-label required">
                                                        Product Name *
                                                    </label>
                                                    <input type="text" v-model="form.item_name"
                                                        class="form-control form-control-lg"
                                                        :class="{ 'is-invalid': errors.item_name }"
                                                        placeholder="Enter product name" required />
                                                    <div v-if="errors.item_name" class="invalid-feedback d-block">
                                                        <i class="bi bi-exclamation-triangle me-1"></i>
                                                        {{ errors.item_name[0] }}
                                                    </div>
                                                </div>

                                                <!-- CATEGORY -->
                                                <div class="col-md-6">
                                                    <label class="form-label required">Category *</label>
                                                    <div class="input-group input-group-lg">
                                                        <select class="form-select" v-model="form.category_id"
                                                            @change="handleCategoryChange" required>
                                                            <option value="">Select Category</option>
                                                            <option v-for="cat in categories" :key="cat.id"
                                                                :value="cat.id">
                                                                {{ cat.category }}
                                                            </option>
                                                        </select>
                                                    </div>
                                                    <small v-if="errors.category_id" class="text-danger">
                                                        {{ errors.category_id[0] }}
                                                    </small>
                                                </div>

                                                <!-- TYPE -->
                                                <div class="col-md-6">
                                                    <label class="form-label required">Type *</label>
                                                    <div class="input-group input-group-lg">
                                                        <select class="form-select" v-model="form.type_id"
                                                            :disabled="!form.category_id" required>
                                                            <option value="">Select Type</option>
                                                            <option v-for="type in filteredTypes" :key="type.id"
                                                                :value="type.id">
                                                                {{ type.type }}
                                                            </option>
                                                        </select>
                                                    </div>
                                                    <small v-if="errors.type_id" class="text-danger">
                                                        {{ errors.type_id[0] }}
                                                    </small>
                                                </div>

                                                <!-- LOCATION -->
                                                <div class="col-md-6">
                                                    <label class="form-label required">Location *</label>
                                                    <div class="input-group input-group-lg">
                                                        <select class="form-select" v-model="form.location_id" required>
                                                            <option value="">Select Location</option>
                                                            <option v-for="location in locations" :key="location.id"
                                                                :value="location.id">
                                                                {{ location.location }}
                                                            </option>
                                                        </select>
                                                    </div>
                                                    <small v-if="errors.location_id" class="text-danger">
                                                        {{ errors.location_id[0] }}
                                                    </small>
                                                </div>

                                                <!-- COLOR -->
                                                <div class="col-md-6">
                                                    <label class="form-label">Color</label>
                                                    <div class="input-group input-group-lg">
                                                        <select class="form-select" v-model="form.color">
                                                            <option value="">Select Color</option>
                                                            <option v-for="color in colors" :key="color.id"
                                                                :value="color.color">
                                                                {{ color.color }}
                                                            </option>
                                                        </select>
                                                    </div>
                                                    <small v-if="errors.color" class="text-danger">
                                                        {{ errors.color[0] }}
                                                    </small>
                                                </div>

                                                <!-- Price & Discount -->
                                                <div class="col-md-6">
                                                    <label class="form-label required">
                                                        Price (UGX) *
                                                    </label>
                                                    <div class="input-group input-group-lg">
                                                        <span class="input-group-text bg-light">UGX</span>
                                                        <input type="number" v-model="form.sales_price"
                                                            class="form-control"
                                                            :class="{ 'is-invalid': errors.sales_price }"
                                                            placeholder="0.00" min="0" step="0.01" required />
                                                    </div>
                                                    <div v-if="errors.sales_price" class="invalid-feedback d-block">
                                                        <i class="bi bi-exclamation-triangle me-1"></i>
                                                        {{ errors.sales_price[0] }}
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <label class="form-label">
                                                        Discount (%)
                                                    </label>
                                                    <div class="input-group input-group-lg">
                                                        <input type="number" v-model="form.discount"
                                                            class="form-control"
                                                            :class="{ 'is-invalid': errors.discount }"
                                                            placeholder="0-100" min="0" max="100" />
                                                        <span class="input-group-text bg-light">%</span>
                                                    </div>
                                                    <div v-if="errors.discount" class="invalid-feedback d-block">
                                                        <i class="bi bi-exclamation-triangle me-1"></i>
                                                        {{ errors.discount[0] }}
                                                    </div>
                                                    <div class="form-text" v-if="form.discount">
                                                        Final Price: UGX {{ calculateFinalPrice }}
                                                    </div>
                                                </div>

                                                <!-- Condition -->
                                                <div class="col-md-6">
                                                    <label class="form-label required">Condition *</label>
                                                    <div class="input-group input-group-lg">
                                                        <select class="form-select" v-model="form.condition" required>
                                                            <option value="">Select Condition</option>
                                                            <option value="new">New</option>
                                                            <option value="used">Used</option>
                                                            <option value="refurbished">Refurbished</option>
                                                        </select>
                                                    </div>
                                                    <small v-if="errors.condition" class="text-danger">
                                                        {{ errors.condition[0] }}
                                                    </small>
                                                </div>

                                                <!-- GENDER -->
                                                <div class="col-md-6">
                                                    <label class="form-label required">Gender *</label>
                                                    <div class="input-group input-group-lg">
                                                        <select class="form-select" v-model="form.gender" required>
                                                            <option value="">Select Gender</option>
                                                            <option value="unisex">Unisex</option>
                                                            <option value="women">Women</option>
                                                            <option value="men">Men</option>
                                                            <option value="children">Children</option>
                                                            <option value="babies">Babies</option>
                                                        </select>
                                                    </div>
                                                    <small v-if="errors.gender" class="text-danger">
                                                        {{ errors.gender[0] }}
                                                    </small>
                                                </div>

                                                <!-- BRAND -->
                                                <div class="col-md-6">
                                                    <label class="form-label required">Brand *</label>
                                                    <div class="input-group input-group-lg">
                                                        <input type="text" v-model="form.brand"
                                                            class="form-control"
                                                            :class="{ 'is-invalid': errors.brand }"
                                                            placeholder="Brand" required />
                                                    </div>
                                                    <div v-if="errors.brand" class="invalid-feedback d-block">
                                                        <i class="bi bi-exclamation-triangle me-1"></i>
                                                        {{ errors.brand[0] }}
                                                    </div>
                                                </div>

                                                <!-- SIZE -->
                                                <div class="col-md-6">
                                                    <label class="form-label required">Size *</label>
                                                    <div class="input-group input-group-lg">
                                                        <input type="text" v-model="form.size"
                                                            class="form-control"
                                                            :class="{ 'is-invalid': errors.size }"
                                                            placeholder="Size" required />
                                                    </div>
                                                    <div v-if="errors.size" class="invalid-feedback d-block">
                                                        <i class="bi bi-exclamation-triangle me-1"></i>
                                                        {{ errors.size[0] }}
                                                    </div>
                                                </div>

                                                <!-- QUANTITY -->
                                                <div class="col-md-6">
                                                    <label class="form-label required">Quantity *</label>
                                                    <div class="input-group input-group-lg">
                                                        <input type="number" v-model="form.quantity"
                                                            class="form-control"
                                                            :class="{ 'is-invalid': errors.quantity }"
                                                            placeholder="Quantity" min="1" required />
                                                    </div>
                                                    <div v-if="errors.quantity" class="invalid-feedback d-block">
                                                        <i class="bi bi-exclamation-triangle me-1"></i>
                                                        {{ errors.quantity[0] }}
                                                    </div>
                                                </div>

                                                <!-- MEASURES -->
                                                <div class="col-md-6">
                                                    <label class="form-label">Measures</label>
                                                    <div class="input-group input-group-lg">
                                                        <select class="form-select" v-model="form.measure">
                                                            <option value="">Select Measure</option>
                                                            <option v-for="measure in measures" :key="measure.id"
                                                                :value="measure.measure">
                                                                {{ measure.measure }}
                                                            </option>
                                                        </select>
                                                    </div>
                                                    <small v-if="errors.measure" class="text-danger">
                                                        {{ errors.measure[0] }}
                                                    </small>
                                                </div>

                                                <!-- BRAND NAME -->
                                                <div class="col-md-6">
                                                    <label class="form-label">Brand Name</label>
                                                    <div class="input-group input-group-lg">
                                                        <input type="text" v-model="form.brand_name"
                                                            class="form-control"
                                                            :class="{ 'is-invalid': errors.brand_name }"
                                                            placeholder="Brand Name" />
                                                    </div>
                                                    <div v-if="errors.brand_name" class="invalid-feedback d-block">
                                                        <i class="bi bi-exclamation-triangle me-1"></i>
                                                        {{ errors.brand_name[0] }}
                                                    </div>
                                                </div>

                                                <!-- OFFERS -->
                                                <div class="col-md-6">
                                                    <label class="form-label required">Offers *</label>
                                                    <div class="input-group input-group-lg">
                                                        <select class="form-select" v-model="form.offer" required>
                                                            <option value="">Select Offer</option>
                                                            <option v-for="adcharge in adcharges" :key="adcharge.id"
                                                                :value="adcharge.offer">
                                                                {{ adcharge.offer }}
                                                            </option>
                                                        </select>
                                                    </div>
                                                    <small v-if="errors.offer" class="text-danger">
                                                        {{ errors.offer[0] }}
                                                    </small>
                                                </div>

                                                <!-- MANUFACTURING DATE -->
                                                <div class="col-md-6">
                                                    <label class="form-label">Manufacturing Date</label>
                                                    <div class="input-group input-group-lg">
                                                        <input type="date" v-model="form.manufacturing_date"
                                                            class="form-control"
                                                            :class="{ 'is-invalid': errors.manufacturing_date }" />
                                                    </div>
                                                    <small v-if="errors.manufacturing_date" class="text-danger">
                                                        {{ errors.manufacturing_date[0] }}
                                                    </small>
                                                </div>

                                                <!-- STATUS (for edit mode) -->
                                                <div class="col-md-6" v-if="editMode">
                                                    <label class="form-label required">Status *</label>
                                                    <div class="input-group input-group-lg">
                                                        <select class="form-select" v-model="form.status" required>
                                                            <option value="available">Available</option>
                                                            <option value="sold">Sold</option>
                                                            <option value="stopped">Stopped</option>
                                                        </select>
                                                    </div>
                                                    <small v-if="errors.status" class="text-danger">
                                                        {{ errors.status[0] }}
                                                    </small>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Category Specific Fields -->
                                        <div class="form-section mb-4" v-if="showCategorySpecificFields">
                                            <h6 class="section-title">
                                                <i class="bi bi-tags me-2"></i>
                                                {{ selectedCategoryName }} Specific Details
                                            </h6>
                                            <div class="row g-3">
                                                <!-- PRODUCE CATEGORY FIELDS -->
                                                <template v-if="selectedCategoryCode === 'PRO'">
                                                    <div class="col-md-6">
                                                        <label class="form-label">Breed</label>
                                                        <div class="input-group input-group-lg">
                                                            <input type="text" v-model="form.breed"
                                                                class="form-control"
                                                                :class="{ 'is-invalid': errors.breed }"
                                                                placeholder="Breed" />
                                                        </div>
                                                        <div v-if="errors.breed" class="invalid-feedback d-block">
                                                            <i class="bi bi-exclamation-triangle me-1"></i>
                                                            {{ errors.breed[0] }}
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <label class="form-label">Weight</label>
                                                        <div class="input-group input-group-lg">
                                                            <input type="text" v-model="form.weight"
                                                                class="form-control"
                                                                :class="{ 'is-invalid': errors.weight }"
                                                                placeholder="Weight" />
                                                        </div>
                                                        <div v-if="errors.weight" class="invalid-feedback d-block">
                                                            <i class="bi bi-exclamation-triangle me-1"></i>
                                                            {{ errors.weight[0] }}
                                                        </div>
                                                    </div>
                                                </template>

                                                <!-- VEHICLES CATEGORY FIELDS -->
                                                <template v-else-if="selectedCategoryCode === 'VE'">
                                                    <div class="col-md-6">
                                                        <label class="form-label">Model</label>
                                                        <div class="input-group input-group-lg">
                                                            <input type="text" v-model="form.model"
                                                                class="form-control"
                                                                :class="{ 'is-invalid': errors.model }"
                                                                placeholder="Model" />
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <label class="form-label">Make</label>
                                                        <div class="input-group input-group-lg">
                                                            <input type="text" v-model="form.make"
                                                                class="form-control"
                                                                :class="{ 'is-invalid': errors.make }"
                                                                placeholder="Make" />
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <label class="form-label">Transmission</label>
                                                        <div class="input-group input-group-lg">
                                                            <input type="text" v-model="form.transmission"
                                                                class="form-control"
                                                                :class="{ 'is-invalid': errors.transmission }"
                                                                placeholder="Transmission" />
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <label class="form-label">Fuel Type</label>
                                                        <div class="input-group input-group-lg">
                                                            <input type="text" v-model="form.fuel"
                                                                class="form-control"
                                                                :class="{ 'is-invalid': errors.fuel }"
                                                                placeholder="Fuel Type" />
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <label class="form-label">Engine Capacity</label>
                                                        <div class="input-group input-group-lg">
                                                            <input type="text" v-model="form.engine_capacity"
                                                                class="form-control"
                                                                :class="{ 'is-invalid': errors.engine_capacity }"
                                                                placeholder="Engine Capacity" />
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <label class="form-label">Year</label>
                                                        <div class="input-group input-group-lg">
                                                            <input type="text" v-model="form.age"
                                                                class="form-control"
                                                                :class="{ 'is-invalid': errors.age }"
                                                                placeholder="Year" />
                                                        </div>
                                                    </div>
                                                </template>

                                                <!-- HOUSES, HOTELS & HOSTELS CATEGORY FIELDS -->
                                                <template v-else-if="selectedCategoryCode === 'HHH'">
                                                    <div class="col-md-6">
                                                        <label class="form-label">Number of Rooms</label>
                                                        <div class="input-group input-group-lg">
                                                            <input type="text" v-model="form.number_of_rooms"
                                                                class="form-control"
                                                                :class="{ 'is-invalid': errors.number_of_rooms }"
                                                                placeholder="Number of Rooms" />
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <label class="form-label">Parking</label>
                                                        <div class="input-group input-group-lg">
                                                            <input type="text" v-model="form.parking"
                                                                class="form-control"
                                                                :class="{ 'is-invalid': errors.parking }"
                                                                placeholder="Parking" />
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <label class="form-label">Security</label>
                                                        <div class="input-group input-group-lg">
                                                            <input type="text" v-model="form.security"
                                                                class="form-control"
                                                                :class="{ 'is-invalid': errors.security }"
                                                                placeholder="Security" />
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <label class="form-label">Features</label>
                                                        <div class="input-group input-group-lg">
                                                            <input type="text" v-model="form.features"
                                                                class="form-control"
                                                                :class="{ 'is-invalid': errors.features }"
                                                                placeholder="Features" />
                                                        </div>
                                                    </div>
                                                </template>

                                                <!-- COMPUTING & ACCESSORIES CATEGORY FIELDS -->
                                                <template v-else-if="selectedCategoryCode === 'CA'">
                                                    <div class="col-md-6">
                                                        <label class="form-label">Processor</label>
                                                        <div class="input-group input-group-lg">
                                                            <input type="text" v-model="form.processor"
                                                                class="form-control"
                                                                :class="{ 'is-invalid': errors.processor }"
                                                                placeholder="Processor" />
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <label class="form-label">RAM</label>
                                                        <div class="input-group input-group-lg">
                                                            <input type="text" v-model="form.ram"
                                                                class="form-control"
                                                                :class="{ 'is-invalid': errors.ram }"
                                                                placeholder="RAM" />
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <label class="form-label">Storage</label>
                                                        <div class="input-group input-group-lg">
                                                            <input type="text" v-model="form.storage"
                                                                class="form-control"
                                                                :class="{ 'is-invalid': errors.storage }"
                                                                placeholder="Storage" />
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <label class="form-label">Operating System</label>
                                                        <div class="input-group input-group-lg">
                                                            <input type="text" v-model="form.operating_system"
                                                                class="form-control"
                                                                :class="{ 'is-invalid': errors.operating_system }"
                                                                placeholder="Operating System" />
                                                        </div>
                                                    </div>
                                                </template>

                                                <!-- Add more category-specific templates as needed -->
                                            </div>
                                        </div>

                                        <!-- Product Images -->
                                        <div class="form-section mb-4">
                                            <h6 class="section-title">
                                                <i class="bi bi-images me-2"></i>Product Images *
                                            </h6>
                                            
                                            <!-- Main Photo Selection -->
                                            <div class="mb-4">
                                                <h6 class="text-primary mb-3">
                                                    <i class="bi bi-star-fill me-2"></i>Main Product Photo
                                                    <span class="badge bg-primary ms-2">Display Image</span>
                                                </h6>
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="main-photo-upload-area"
                                                            :class="{ 'has-image': showMainImage }"
                                                            @click="triggerMainFileInput">
                                                            <div v-if="!showMainImage" class="upload-placeholder">
                                                                <i class="bi bi-camera display-4 text-muted mb-3"></i>
                                                                <h5>Upload Main Product Photo</h5>
                                                                <p class="text-muted">This will be the display image for your product</p>
                                                                <small class="text-muted">JPG, PNG, WEBP up to 5MB</small>
                                                            </div>
                                                            <div v-else class="image-preview-main">
                                                                <img :src="getMainImage()" alt="Main Product" class="preview-img-main">
                                                                <button type="button"
                                                                    class="btn btn-danger btn-sm remove-main-image"
                                                                    @click.stop="removeMainImage">
                                                                    <i class="bi bi-trash"></i>
                                                                </button>
                                                            </div>
                                                        </div>

                                                        <input type="file" ref="mainFileInput"
                                                            @change="handleMainFileChange" class="d-none"
                                                            accept="image/*" :disabled="loading" />

                                                        <div v-if="errors.photo" class="invalid-feedback d-block mt-2">
                                                            <i class="bi bi-exclamation-triangle me-1"></i>
                                                            {{ errors.photo[0] }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Additional Photos -->
                                            <div class="additional-photos-section">
                                                <h6 class="text-secondary mb-3">
                                                    <i class="bi bi-collection me-2"></i>Additional Photos
                                                    <span class="badge bg-secondary ms-2">Optional</span>
                                                </h6>
                                                
                                                <div class="row">
                                                    <!-- Add New Photo Button -->
                                                    <div class="col-md-3 col-sm-4 col-6 mb-3">
                                                        <div class="additional-photo-upload" @click="triggerAdditionalFileInput">
                                                            <div class="add-photo-placeholder">
                                                                <i class="bi bi-plus-circle display-4 text-muted"></i>
                                                                <p class="mt-2 mb-0">Add Photo</p>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Additional Photos Preview -->
                                                    <div class="col-md-3 col-sm-4 col-6 mb-3" v-for="(photo, index) in additionalPhotos" :key="index">
                                                        <div class="additional-photo-preview" :class="{ 'is-main': isMainPhoto(photo) }">
                                                            <img :src="getPhotoUrl(photo)" alt="Additional Photo" 
                                                                class="additional-preview-img">
                                                            <div class="photo-actions">
                                                                <button type="button" class="btn btn-primary btn-sm set-main-btn"
                                                                    @click="setAsMainPhoto(index)"
                                                                    :title="isMainPhoto(photo) ? 'Main Photo' : 'Set as Main'"
                                                                    :class="{ 'active': isMainPhoto(photo) }">
                                                                    <i class="bi" :class="isMainPhoto(photo) ? 'bi-star-fill' : 'bi-star'"></i>
                                                                </button>
                                                                <button type="button" class="btn btn-danger btn-sm remove-additional-btn"
                                                                    @click="removeAdditionalPhoto(index)">
                                                                    <i class="bi bi-trash"></i>
                                                                </button>
                                                            </div>
                                                            <div v-if="isMainPhoto(photo)" class="main-photo-badge">
                                                                <i class="bi bi-star-fill"></i> Main
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <input type="file" ref="additionalFileInput"
                                                    @change="handleAdditionalFileChange" class="d-none"
                                                    accept="image/*" multiple :disabled="loading" />

                                                <div class="form-text mt-2">
                                                    <i class="bi bi-info-circle me-1"></i>
                                                    You can upload up to 10 additional photos. Click the star icon to set a photo as main display.
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Description -->
                                        <div class="form-section mb-4">
                                            <h6 class="section-title">
                                                <i class="bi bi-card-text me-2"></i>Description *
                                            </h6>
                                            <div class="row">
                                                <div class="col-12">
                                                    <label class="form-label required">
                                                        Product Description *
                                                    </label>
                                                    <textarea v-model="form.description" class="form-control"
                                                        :class="{ 'is-invalid': errors.description }" rows="5"
                                                        placeholder="Describe your product in detail..."
                                                        required></textarea>
                                                    <div v-if="errors.description" class="invalid-feedback d-block">
                                                        <i class="bi bi-exclamation-triangle me-1"></i>
                                                        {{ errors.description[0] }}
                                                    </div>
                                                    <div class="form-text">
                                                        <span :class="{ 'text-danger': descriptionLength > 500 }">
                                                            {{ descriptionLength }}/500 characters
                                                        </span>
                                                        <span class="ms-3">
                                                            <i class="bi bi-lightbulb me-1"></i>
                                                            Include features, specifications, and condition details
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Form Actions -->
                                        <div class="form-section">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div>
                                                    <router-link to="/my-products" class="btn btn-outline-secondary">
                                                        <i class="bi bi-x-circle me-2"></i>Cancel
                                                    </router-link>
                                                </div>
                                                <div class="d-flex gap-2">
                                                    <button type="button" class="btn btn-outline-primary"
                                                        @click="saveAsDraft" :disabled="loading">
                                                        <i class="bi bi-save me-2"></i>Save as Draft
                                                    </button>
                                                    <button type="submit" class="btn btn-primary btn-lg px-4"
                                                        :disabled="loading || !isFormValid">
                                                        <span v-if="loading">
                                                            <span class="spinner-border spinner-border-sm me-2"></span>
                                                            Saving...
                                                        </span>
                                                        <span v-else>
                                                            <i class="bi bi-check-circle me-2"></i>
                                                            <span v-if="editMode">Update</span>
                                                            <span v-else>Publish</span> Product
                                                        </span>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <AppFooter />
    </div>
</template>

<script setup>
import { reactive, ref, computed, onMounted, watch } from "vue"
import { useRouter, useRoute } from "vue-router"
import { useAuthStore } from '../../stores/auth'
import Navbar from '../layouts/Navbar.vue'
import SellerSidebar from '../layouts/SellerSidebar.vue'
import AppFooter from '../layouts/AppFooter.vue'

const router = useRouter()
const route = useRoute()
const authStore = useAuthStore()

// Initialize form with all possible fields
const form = reactive({
    // Common fields
    item_name: "",
    category_id: "",
    type_id: "",
    location_id: "",
    sales_price: "",
    discount: "",
    description: "",
    gender: "",
    condition: "",
    quantity: "1",
    brand: "",
    size: "",
    measure: "",
    offer: "",
    color: "",
    brand_name: "",
    manufacturing_date: "",
    photo: "", // Main photo (base64 or filename)
    status: "available",
    
    // Category-specific fields
    breed: "",
    weight: "",
    model: "",
    material: "",
    number_of_rooms: "",
    security: "",
    power: "",
    water: "",
    features: "",
    parking: "",
    agent_fee: "",
    state: "",
    conscent: "",
    location_status: "",
    transmission: "",
    fuel: "",
    make: "",
    steering: "",
    number_plate: "",
    engine_capacity: "",
    top_speed: "",
    number_of_cylinders: "",
    fuel_capacity: "",
    number_of_gears: "",
    age: "",
    wheel_size: "",
    body_type: "",
    watts: "",
    operating_system: "",
    graphic_card: "",
    storage_type: "",
    processor: "",
    storage: "",
    ram: "",
    sim: "",
    display_type: "",
    expiry_date: "",
    care_information: "",
    store_information: "",
    working_hours: ""
})

const categories = ref([])
const allTypes = ref([])
const filteredTypes = ref([])
const colors = ref([])
const locations = ref([])
const adcharges = ref([])
const measures = ref([])
const errors = ref({})
const loading = ref(false)
const pageLoading = ref(true)
const mainFileInput = ref(null)
const additionalFileInput = ref(null)
const editMode = ref(false)
const productId = ref(null)

// Store for additional photos
const additionalPhotos = ref([])

/**
 * LOAD DATA
 */
onMounted(async () => {
    pageLoading.value = true

    await fetchCategories()
    await fetchAllTypes()
    await fetchColors()
    await fetchLocations()
    await fetchOffers()
    await fetchMeasures()

    // Check if editing
    if (route.params.id) {
        editMode.value = true
        productId.value = route.params.id
        await getProductForEdit()
    }

    pageLoading.value = false
})

/**
 * FETCH CATEGORIES
 */
const fetchCategories = async () => {
    try {
        const response = await axios.get("/api/categories")
        categories.value = response.data.categories.data || []
    } catch (error) {
        console.error("Failed to fetch categories", error)
    }
}

/**
 * FETCH ALL TYPES
 */
const fetchAllTypes = async () => {
    try {
        const response = await axios.get("/api/types")
        allTypes.value = response.data.types.data || []
        filteredTypes.value = allTypes.value
    } catch (error) {
        console.error("Failed to fetch types", error)
    }
}

/**
 * FETCH TYPES BY CATEGORY
 */
const fetchTypesByCategory = async (categoryId) => {
    try {
        const response = await axios.get(`/api/types?category_id=${categoryId}`)
        filteredTypes.value = response.data.types.data || []
        // Reset type selection when category changes
        form.type_id = ""
    } catch (error) {
        console.error("Failed to fetch types by category", error)
        filteredTypes.value = []
    }
}

/**
 * FETCH COLORS
 */
const fetchColors = async () => {
    try {
        const response = await axios.get("/api/colors")
        colors.value = response.data.colors.data || []
    } catch (error) {
        console.error("Failed to fetch colors", error)
    }
}

/**
 * FETCH LOCATIONS
 */
const fetchLocations = async () => {
    try {
        const response = await axios.get("/api/locations")
        locations.value = response.data.locations.data || []
    } catch (error) {
        console.error("Failed to fetch locations", error)
    }
}

/**
 * FETCH OFFERS
 */
const fetchOffers = async () => {
    try {
        const response = await axios.get("/api/adcharges")
        adcharges.value = response.data.adcharges.data || []
    } catch (error) {
        console.error("Failed to fetch offers", error)
    }
}

/**
 * FETCH MEASURES
 */
const fetchMeasures = async () => {
    try {
        const response = await axios.get("/api/measures")
        measures.value = response.data.measures.data || []
    } catch (error) {
        console.error("Failed to fetch measures", error)
    }
}

/**
 * HANDLE CATEGORY CHANGE
 */
const handleCategoryChange = () => {
    if (form.category_id) {
        fetchTypesByCategory(form.category_id)
    } else {
        filteredTypes.value = []
        form.type_id = ""
    }
}

/**
 * GET PRODUCT FOR EDIT
 */
const getProductForEdit = async () => {
    try {
        const response = await axios.get(`/api/products/${productId.value}/edit`)
        const product = response.data.product
        
        // Populate common fields
        form.item_name = product.item_name || ""
        form.category_id = product.category_id || ""
        form.type_id = product.type_id || ""
        form.location_id = product.location_id || ""
        form.sales_price = product.sales_price || ""
        form.discount = product.discount || ""
        form.description = product.description || ""
        form.gender = product.gender || "unisex"
        form.condition = product.condition || ""
        form.quantity = product.quantity || "1"
        form.brand = product.brand || ""
        form.size = product.size || ""
        form.measure = product.measure || ""
        form.offer = product.offer || ""
        form.color = product.color || ""
        form.brand_name = product.brand_name || ""
        form.manufacturing_date = product.manufacturing_date || ""
        form.photo = product.photo || ""
        form.status = product.status || "available"
        
        // Populate category-specific fields
        form.breed = product.breed || ""
        form.weight = product.weight || ""
        form.model = product.model || ""
        form.material = product.material || ""
        form.number_of_rooms = product.number_of_rooms || ""
        form.security = product.security || ""
        form.power = product.power || ""
        form.water = product.water || ""
        form.features = product.features || ""
        form.parking = product.parking || ""
        form.agent_fee = product.agent_fee || ""
        form.state = product.state || ""
        form.conscent = product.conscent || ""
        form.location_status = product.location_status || ""
        form.transmission = product.transmission || ""
        form.fuel = product.fuel || ""
        form.make = product.make || ""
        form.steering = product.steering || ""
        form.number_plate = product.number_plate || ""
        form.engine_capacity = product.engine_capacity || ""
        form.top_speed = product.top_speed || ""
        form.number_of_cylinders = product.number_of_cylinders || ""
        form.fuel_capacity = product.fuel_capacity || ""
        form.number_of_gears = product.number_of_gears || ""
        form.age = product.age || ""
        form.wheel_size = product.wheel_size || ""
        form.body_type = product.body_type || ""
        form.watts = product.watts || ""
        form.operating_system = product.operating_system || ""
        form.graphic_card = product.graphic_card || ""
        form.storage_type = product.storage_type || ""
        form.processor = product.processor || ""
        form.storage = product.storage || ""
        form.ram = product.ram || ""
        form.sim = product.sim || ""
        form.display_type = product.display_type || ""
        form.expiry_date = product.expiry_date || ""
        form.care_information = product.care_information || ""
        form.store_information = product.store_information || ""
        form.working_hours = product.working_hours || ""
        
        // Load additional photos if they exist
        if (product.additional_photos) {
            try {
                const additional = JSON.parse(product.additional_photos)
                if (Array.isArray(additional)) {
                    additionalPhotos.value = additional.map(photo => {
                        // Check if this is the main photo
                        const isMain = (photo === product.photo)
                        return {
                            filename: photo,
                            isMain: isMain,
                            type: 'existing' // Mark as existing photo from database
                        }
                    })
                }
            } catch (e) {
                console.error("Error parsing additional photos", e)
            }
        }
        
        // Load types for the selected category
        if (form.category_id) {
            await fetchTypesByCategory(form.category_id)
        }
        
    } catch (error) {
        console.error("Failed to load product", error)
        window.toast.fire({
            icon: 'error',
            title: 'Failed to load product data'
        })
    }
}

// Computed properties
const showMainImage = computed(() => {
    return form.photo && form.photo.length > 0
})

const descriptionLength = computed(() => {
    return form.description.length
})

const isFormValid = computed(() => {
    return form.item_name && form.description && form.sales_price && form.condition && 
           form.category_id && form.type_id && form.location_id && form.gender && 
           form.quantity && form.brand && form.size && form.offer && form.photo
})

const calculateFinalPrice = computed(() => {
    if (!form.sales_price) return '0.00'
    const sales_price = parseFloat(form.sales_price)
    const discount = form.discount ? parseFloat(form.discount) : 0
    if (discount > 0) {
        const discounted = sales_price - (sales_price * discount / 100)
        return discounted.toFixed(2)
    }
    return sales_price.toFixed(2)
})

const selectedCategory = computed(() => {
    return categories.value.find(cat => cat.id === form.category_id)
})

const selectedCategoryName = computed(() => {
    return selectedCategory.value ? selectedCategory.value.category : ""
})

const selectedCategoryCode = computed(() => {
    return selectedCategory.value ? selectedCategory.value.code : ""
})

const showCategorySpecificFields = computed(() => {
    return form.category_id && selectedCategoryCode.value
})

// Image helper methods
const getMainImage = () => {
    if (form.photo) {
        if (form.photo.indexOf("base64") !== -1 || form.photo.startsWith("data:image")) {
            return form.photo
        } else if (form.photo) {
            return "/upload/" + form.photo
        }
    }
    return ""
}

const getPhotoUrl = (photo) => {
    if (!photo) return ""
    
    // If it's a base64 string
    if (typeof photo === 'string') {
        if (photo.indexOf("base64") !== -1 || photo.startsWith("data:image")) {
            return photo
        } else {
            return "/upload/" + photo
        }
    } 
    // If it's an object with base64 property (new upload)
    else if (photo.base64) {
        return photo.base64
    }
    // If it's an object with filename property (existing from database)
    else if (photo.filename) {
        return "/upload/" + photo.filename
    }
    
    return ""
}

const isMainPhoto = (photo) => {
    if (!photo) return false
    
    const photoUrl = getPhotoUrl(photo)
    const mainUrl = getMainImage()
    
    // Compare the actual URLs
    return photoUrl === mainUrl
}

// Main photo methods
const triggerMainFileInput = () => {
    if (!loading.value) {
        mainFileInput.value.click()
    }
}

const handleMainFileChange = (e) => {
    const file = e.target.files[0]
    if (file) {
        // Check file size (5MB max)
        if (file.size > 5 * 1024 * 1024) {
            window.toast.fire({
                icon: 'error',
                title: 'File too large! Maximum size is 5MB.'
            })
            return
        }

        // Check file type
        if (!file.type.match('image.*')) {
            window.toast.fire({
                icon: 'error',
                title: 'Please select an image file!'
            })
            return
        }

        let reader = new FileReader()
        reader.onloadend = () => {
            form.photo = reader.result
        }
        reader.onerror = () => {
            window.toast.fire({
                icon: 'error',
                title: 'Error reading file!'
            })
        }
        reader.readAsDataURL(file)
    }
}

const removeMainImage = () => {
    form.photo = ""
    if (mainFileInput.value) {
        mainFileInput.value.value = ""
    }
}

// Additional photos methods
const triggerAdditionalFileInput = () => {
    if (!loading.value) {
        additionalFileInput.value.click()
    }
}

const handleAdditionalFileChange = (e) => {
    const files = Array.from(e.target.files)
    
    // Check total number of photos (max 10 additional)
    if (additionalPhotos.value.length + files.length > 10) {
        window.toast.fire({
            icon: 'error',
            title: 'Maximum 10 additional photos allowed!'
        })
        return
    }
    
    // Process each file
    files.forEach((file) => {
        // Check file size (5MB max)
        if (file.size > 5 * 1024 * 1024) {
            window.toast.fire({
                icon: 'error',
                title: `File "${file.name}" is too large! Maximum size is 5MB.`
            })
            return
        }

        // Check file type
        if (!file.type.match('image.*')) {
            window.toast.fire({
                icon: 'error',
                title: `File "${file.name}" is not an image!`
            })
            return
        }

        let reader = new FileReader()
        reader.onloadend = () => {
            // Create a unique ID for this photo
            const photoId = Date.now() + Math.random().toString(36).substr(2, 9)
            
            additionalPhotos.value.push({
                id: photoId,
                base64: reader.result,
                filename: file.name,
                file: file,
                isMain: false,
                type: 'new' // Mark as newly uploaded
            })
        }
        reader.onerror = () => {
            window.toast.fire({
                icon: 'error',
                title: `Error reading file "${file.name}"!`
            })
        }
        reader.readAsDataURL(file)
    })
    
    // Reset file input
    e.target.value = ""
}

const removeAdditionalPhoto = (index) => {
    // Check if we're removing the main photo
    if (isMainPhoto(additionalPhotos.value[index])) {
        window.toast.fire({
            icon: 'warning',
            title: 'Cannot remove main photo! Set another photo as main first.'
        })
        return
    }
    
    additionalPhotos.value.splice(index, 1)
}

const setAsMainPhoto = (index) => {
    const photo = additionalPhotos.value[index]
    if (photo.base64) {
        form.photo = photo.base64
    } else if (photo.filename) {
        form.photo = photo.filename
    }
    
    // Update isMain flag for all photos
    additionalPhotos.value.forEach((p, i) => {
        p.isMain = (i === index)
    })
}

// Save method
const handleSave = async () => {
    loading.value = true
    errors.value = {}

    try {
        // Prepare additional photos array
        // For new uploads: send base64 strings
        // For existing photos: send filenames
        const additionalPhotosData = additionalPhotos.value.map(photo => {
            if (photo.type === 'new' && photo.base64) {
                return photo.base64
            } else if (photo.filename) {
                return photo.filename
            }
            return null
        }).filter(photo => photo !== null)

        // Add seller ID and additional photos to form
        const formData = {
            ...form,
            seller_id: authStore.user?.id,
            additional_photos: additionalPhotosData.length > 0 ? additionalPhotosData : null
        }

        console.log('Form data being sent:', {
            item_name: formData.item_name,
            photo_count: additionalPhotosData.length,
            has_main_photo: !!formData.photo
        })

        let response
        if (editMode.value) {
            response = await axios.put(`/api/products/${productId.value}`, formData)
        } else {
            response = await axios.post('/api/products', formData)
        }

        if (response.data.success) {
            window.toast.fire({
                icon: "success",
                title: editMode.value ? "Product Updated Successfully!" : "Product Added Successfully!"
            })

            if (!editMode.value) {
                // Reset form for new product
                Object.keys(form).forEach(key => {
                    if (key !== 'status') {
                        form[key] = ""
                    }
                })
                form.quantity = "1"
                form.status = "available"
                form.gender = "unisex"
                form.photo = ""
                additionalPhotos.value = []
            }

            // Redirect to seller's products page
            router.push("/my-products")
        }

    } catch (error) {
        console.error('Save error:', error)
        if (error.response && error.response.status === 422) {
            errors.value = error.response.data.errors
            window.toast.fire({
                icon: 'error',
                title: 'Please fix the form errors!'
            })
        } else {
            window.toast.fire({
                icon: 'error',
                title: 'An error occurred. Please try again.'
            })
            console.error('Full error:', error)
        }
    } finally {
        loading.value = false
    }
}

const saveAsDraft = async () => {
    form.status = "stopped" // Using "stopped" as draft status
    await handleSave()
}
</script>

<style scoped>
.seller-dashboard-layout {
    min-height: 100vh;
    background-color: #f8f9fa;
}

.dashboard-container {
    display: flex;
    min-height: calc(100vh - 70px);
}

.dashboard-main {
    flex: 1;
    padding: 20px;
    overflow-y: auto;
}

.dashboard-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 30px;
    padding: 20px;
    background: white;
    border-radius: 10px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.header-content h1 {
    color: #2c3e50;
    font-weight: 600;
    margin-bottom: 5px;
}

.breadcrumb {
    background: none;
    padding: 0;
    margin: 0;
}

.breadcrumb-item a {
    color: #6c757d;
    text-decoration: none;
}

.breadcrumb-item a:hover {
    color: #007bff;
}

.form-card {
    border-radius: 12px;
    border: none;
}

.form-card .card-header {
    border-bottom: 1px solid #eaeaea;
}

.section-title {
    color: #2c3e50;
    font-weight: 600;
    padding-bottom: 10px;
    border-bottom: 2px solid #007bff;
    margin-bottom: 20px;
}

.form-section {
    padding: 20px;
    background: white;
    border-radius: 8px;
    margin-bottom: 20px;
    border: 1px solid #eaeaea;
}

.form-label.required::after {
    content: " *";
    color: #dc3545;
}

/* Main Photo Upload Area */
.main-photo-upload-area {
    border: 2px dashed #007bff;
    border-radius: 10px;
    padding: 40px 20px;
    text-align: center;
    cursor: pointer;
    transition: all 0.3s ease;
    background: #f0f7ff;
    min-height: 250px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.main-photo-upload-area:hover {
    border-color: #0056b3;
    background: #e6f2ff;
}

.main-photo-upload-area.has-image {
    border-style: solid;
    padding: 10px;
}

.image-preview-main {
    position: relative;
    max-width: 300px;
    margin: 0 auto;
}

.preview-img-main {
    width: 100%;
    height: 200px;
    border-radius: 8px;
    object-fit: cover;
    border: 3px solid #007bff;
}

.remove-main-image {
    position: absolute;
    top: 10px;
    right: 10px;
    border-radius: 50%;
    width: 30px;
    height: 30px;
    display: flex;
    align-items: center;
    justify-content: center;
}

/* Additional Photos */
.additional-photos-section {
    margin-top: 30px;
}

.additional-photo-upload {
    border: 2px dashed #6c757d;
    border-radius: 8px;
    padding: 20px;
    text-align: center;
    cursor: pointer;
    transition: all 0.3s ease;
    background: #f8f9fa;
    height: 150px;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
}

.additional-photo-upload:hover {
    border-color: #007bff;
    background: #f0f7ff;
}

.add-photo-placeholder i {
    font-size: 48px;
}

.additional-photo-preview {
    position: relative;
    border-radius: 8px;
    overflow: hidden;
    height: 150px;
    border: 2px solid transparent;
    transition: all 0.3s ease;
}

.additional-photo-preview.is-main {
    border-color: #ffc107;
    box-shadow: 0 0 0 3px rgba(255, 193, 7, 0.2);
}

.additional-preview-img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.photo-actions {
    position: absolute;
    top: 5px;
    right: 5px;
    display: flex;
    gap: 5px;
    opacity: 0;
    transition: opacity 0.3s ease;
}

.additional-photo-preview:hover .photo-actions {
    opacity: 1;
}

.set-main-btn, .remove-additional-btn {
    border-radius: 50%;
    width: 30px;
    height: 30px;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 0;
}

.set-main-btn.active {
    background-color: #ffc107;
    border-color: #ffc107;
}

.set-main-btn.active:hover {
    background-color: #e0a800;
    border-color: #d39e00;
}

.main-photo-badge {
    position: absolute;
    bottom: 5px;
    left: 5px;
    background: rgba(255, 193, 7, 0.9);
    color: #212529;
    padding: 2px 8px;
    border-radius: 12px;
    font-size: 0.75rem;
    font-weight: 500;
}

/* Form Controls */
.form-control, .form-select {
    border-radius: 8px;
    padding: 12px 15px;
    border: 1px solid #ced4da;
    transition: all 0.3s ease;
}

.form-control:focus, .form-select:focus {
    border-color: #80bdff;
    box-shadow: 0 0 0 0.2rem rgba(0,123,255,.25);
}

.form-control-lg {
    padding: 15px;
}

.input-group-lg .input-group-text {
    padding: 15px;
}

.invalid-feedback {
    font-size: 0.875em;
}

.form-text {
    font-size: 0.875em;
    color: #6c757d;
}

.btn {
    border-radius: 8px;
    padding: 10px 20px;
    font-weight: 500;
    transition: all 0.3s ease;
}

.btn-lg {
    padding: 12px 30px;
}

.btn-primary {
    background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
    border: none;
}

.btn-primary:hover {
    background: linear-gradient(135deg, #0056b3 0%, #004085 100%);
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0,123,255,.3);
}

.btn-outline-primary:hover {
    transform: translateY(-2px);
}

.btn:disabled {
    opacity: 0.65;
    cursor: not-allowed;
}

.spinner-border {
    vertical-align: middle;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .dashboard-header {
        flex-direction: column;
        text-align: center;
        gap: 15px;
    }
    
    .header-actions {
        width: 100%;
    }
    
    .form-section {
        padding: 15px;
    }
    
    .btn {
        width: 100%;
        margin-bottom: 10px;
    }
    
    .main-photo-upload-area {
        min-height: 200px;
        padding: 20px 10px;
    }
    
    .additional-photo-upload,
    .additional-photo-preview {
        height: 120px;
    }
}

@media (max-width: 576px) {
    .dashboard-main {
        padding: 10px;
    }
    
    .col-md-6, .col-md-12, .col-md-3, .col-sm-4, .col-6 {
        margin-bottom: 15px;
    }
    
    .main-photo-upload-area {
        min-height: 180px;
    }
    
    .preview-img-main {
        height: 150px;
    }
    
    .photo-actions {
        opacity: 1; /* Always show on mobile */
    }
}
</style>