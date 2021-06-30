<template>

    <div id="page-user-create">

        <vx-card title="Product info" class="mb-base">
            <form action="">
                <vx-card class="mt-base" no-shadow card-border>

                    <div class="vx-row">
                        <div class="vx-col w-full">
                            <div class="flex items-end px-3">
                                <feather-icon svgClasses="w-6 h-6" icon="ListIcon" class="mr-2"/>
                                <span class="font-medium text-lg leading-none">Product info</span>
                            </div>
                            <vs-divider/>
                        </div>
                    </div>
                    <div class="vx-row">
                        <!-- required -->
                        <div class="vx-col w-full">
                            <vs-input v-model="form.name"
                                      class="mt-5 w-full" :class="(!form.name)?'required':''"
                                      placeholder="Product Name"
                                      label="Product Name *"/>
                            <span class="text-danger text-sm"
                                  v-if="errors.hasOwnProperty('name')">{{ errors.name[0] }}</span>
                        </div>
                    </div>

                    <div class="vx-row">
                        <!-- required -->
                        <div class="vx-col w-1/2">
                            <vs-input v-model="form.code" label="Product Code *"
                                      class="mt-5 w-full" :class="(!form.code)?'required':''"
                                      placeholder="Product Code *"/>
                            <span class="text-danger text-sm"
                                  v-if="errors.hasOwnProperty('code')">{{ errors.code[0] }}</span>
                        </div>
                        <div class="vx-col w-1/2">
                            <vs-select label="Category" class="mt-5 w-full" autocomplete v-model="form.category_id"
                                       :class="(!form.category_id)?'required':''">
                                <div :key="index" v-for="(category,index) in categories">
                                    <vs-select-group :title="category.name" v-if="category.subcategories">
                                        <vs-select-item :key="index" :value="subcategory.id" :text="subcategory.name"
                                                        v-for="(subcategory,index) in category.subcategories"/>
                                    </vs-select-group>
                                </div>
                            </vs-select>
                            <span class="text-danger text-sm"
                                  v-if="errors.hasOwnProperty('category_id')">{{ errors.category_id[0] }}</span>
                        </div>
                    </div>
                    <div class="vx-row">
                        <!-- required -->
                        <div class="vx-col w-1/2">
                            <vs-input type="number" min="0" v-model="form.price" label="Product Price *"
                                      :class="(!form.price)?'required':''"
                                      class="mt-5 w-full" placeholder="Product Price"/>
                            <span class="text-danger text-sm" v-if="errors.hasOwnProperty('price')">{{ errors.price[0] }}</span>
                        </div>
                        <div class="vx-col w-1/2">
                            <vs-input v-model="form.color" label="Product Color *"
                                      class="mt-5 w-full" :class="(!form.color)?'required':''"
                                      placeholder="Product Color"/>
                            <span class="text-danger text-sm" v-if="errors.hasOwnProperty('color')">{{ errors.color[0] }}</span>
                        </div>
                    </div>

                    <div class="vx-row">
                        <!-- required -->
                        <div class="vx-col w-1/2">
                            <vs-input v-model="form.materials" label="Product Materials *"
                                      class="mt-5 w-full" :class="(!form.materials)?'required':''"
                                      placeholder="Product Materials"/>
                            <span class="text-danger text-sm" v-if="errors.hasOwnProperty('materials')">{{ errors.materials[0] }}</span>
                        </div>
                        <div class="vx-col w-1/2">
                            <vs-input v-model="form.weaving" label="Product Weaving"
                                      class="mt-5 w-full" placeholder="N/A"/>
                            <span class="text-danger text-sm" v-if="errors.hasOwnProperty('weaving')">{{ errors.weaving[0] }}</span>
                        </div>
                    </div>
                    <div class="vx-row">
                        <!-- required -->
                        <div class="vx-col w-1/3">
                            <vs-input type="text" v-model="form.size_l" label="Product Length (cm) *"
                                      class="mt-5 w-full" :class="(!form.size_l)?'required':''"/>
                            <span class="text-danger text-sm" v-if="errors.hasOwnProperty('size_l')">{{ errors.size_l[0] }}</span><span
                            class="text-danger text-sm"></span>
                        </div>
                        <div class="vx-col w-1/3">
                            <vs-input type="text" v-model="form.size_w" label="Product Width (cm) *"
                                      class="mt-5 w-full" :class="(!form.size_w)?'required':''"/>
                            <span class="text-danger text-sm" v-if="errors.hasOwnProperty('size_w')">{{ errors.size_w[0] }}</span>
                        </div>

                        <div class="vx-col w-1/3">
                            <vs-input type="text" v-model="form.size_h" label="Product Height (cm) *"
                                      class="mt-5 w-full" :class="(!form.size_h)?'required':''"/>
                            <span class="text-danger text-sm" v-if="errors.hasOwnProperty('size_h')">{{ errors.size_h[0] }}</span>
                        </div>
                    </div>
                    <div class="vx-row">
                        <!-- required -->
                        <div class="vx-col w-full">
                            <vs-textarea class="mt-5 w-full" placeholder="Extra Info"
                                         label="Extra Info"
                                         v-model="form.info"/>
                            <span class="text-danger text-sm"
                                  v-if="errors.hasOwnProperty('info')">{{ errors.info[0] }}</span>
                        </div>
                    </div>

                </vx-card>
                <vx-card class="mt-base" no-shadow card-border>

                    <div class="vx-row">
                        <div class="vx-col w-full">
                            <div class="flex items-end px-3">
                                <feather-icon svgClasses="w-6 h-6" icon="ListIcon" class="mr-2"/>
                                <span class="font-medium text-lg leading-none">Packing and Loading</span>
                            </div>
                            <vs-divider/>
                        </div>
                    </div>
                    <div class="vx-row">
                        <!-- required -->
                        <div class="vx-col w-1/5">
                            <vs-select label="Carton Package *" class="mt-5 w-full"
                                       :class="(!form.package_id)?'required':''" autocomplete
                                       v-model="form.package_id">
                                <vs-select-item :key="index" :value="item.id" :text="item.name"
                                                v-for="(item,index) in packages"/>
                            </vs-select>
                            <span class="text-danger text-sm"
                                  v-if="errors.hasOwnProperty('package_id')">{{ errors.package_id[0] }}</span>

                        </div>
                        <div class="vx-col w-1/5">
                            <vs-input type="number" min="0" v-model="form.ctn_qty" label="Carton QTY *"
                                      class="mt-5 w-full" :class="(!form.ctn_qty)?'required':''"/>
                            <span class="text-danger text-sm" v-if="errors.hasOwnProperty('ctn_qty')">{{ errors.ctn_qty[0] }}</span>
                        </div>
                        <div class="vx-col w-1/5">
                            <vs-input type="number" min="0" v-model="form.ctn_l" label="Carton Size L (cm) *"
                                      class="mt-5 w-full" :class="(!form.ctn_l)?'required':''"/>
                            <span class="text-danger text-sm" v-if="errors.hasOwnProperty('ctn_l')">{{ errors.ctn_l[0] }}</span>
                        </div>
                        <div class="vx-col w-1/5">
                            <vs-input type="number" v-model="form.ctn_w" label="Carton Size W (cm) *"
                                      class="mt-5 w-full" :class="(!form.ctn_w)?'required':''"/>
                            <span class="text-danger text-sm" v-if="errors.hasOwnProperty('ctn_w')">{{ errors.ctn_w[0] }}</span>
                        </div>

                        <div class="vx-col w-1/5">
                            <vs-input type="number" min="0" v-model="form.ctn_h" label="Carton Size H (cm) *"
                                      class="mt-5 w-full" :class="(!form.ctn_h)?'required':''"/>
                            <span class="text-danger text-sm" v-if="errors.hasOwnProperty('ctn_h')">{{ errors.ctn_h[0] }}</span>
                        </div>
                    </div>
                </vx-card>
                <vx-card class="mt-base" no-shadow card-border>
                    <div class="vx-row">
                        <div class="vx-col w-full">
                            <div class="flex items-end px-3">
                                <feather-icon svgClasses="w-6 h-6" icon="ImageIcon" class="mr-2"/>
                                <input name="images[]" type="file" class="hidden" multiple ref="update_avatar_input"
                                       @change="changeImages"
                                       accept="image/*">
                                <vs-button color="success" type="filled" class="mr-4"
                                           @click="$refs.update_avatar_input.click()">Change
                                    Images
                                </vs-button>
                                <span class="text-danger" v-if="err > 0">Have {{err}} images change fail .</span>
                                <span class="text-danger" v-if="errors_image">{{errors_image}}</span>
                            </div>
                            <vs-divider/>
                        </div>
                    </div>
                    <div class="vx-row centerx">
                        <div class="vx-col h-32 w-40 mb-base"
                             v-for="(image, i) in form.images">
                            <vx-card class="overlay-card overflow-hidden cursor-pointer h-full w-full  items-center"
                                     @click="removeImageStorage(i)">
                                <template slot="no-body">
                                    <img class="rounded h-32 w-40" :src="image['url']"
                                         alt="image">
                                    <div
                                        class="hover:bg-blue-500 card-overlay text-white flex flex-col justify-between items-center">
                                        <!--                                            <h4 class="text-danger mb-4 text-center">Fail</h4>-->
                                        <feather-icon svgClasses="text-danger mb-4 text-center" icon="ImageIcon"
                                                      class="mr-2"/>
                                    </div>
                                </template>
                            </vx-card>
                        </div>
                        <div class="vx-col h-32 w-40 mb-base"
                             v-for="(image, i) in files">
                            <vx-card class="overlay-card overflow-hidden cursor-pointer h-full w-full  items-center"
                                     @click="removeImage(i)">
                                <template slot="no-body">
                                    <img class="rounded h-32 w-40" :src="set_image(image)"
                                         alt="image">
                                    <div
                                        class="hover:bg-blue-500 card-overlay text-white flex flex-col justify-between items-center">
                                        <!--                                            <h4 class="text-danger mb-4 text-center">Fail</h4>-->
                                        <feather-icon svgClasses="text-danger mb-4 text-center" icon="ImageIcon"
                                                      class="mr-2"/>
                                    </div>
                                </template>
                            </vx-card>
                        </div>
                    </div>
                </vx-card>

            </form>
            <!-- Save & Reset Button -->
            <div class="vx-row">
                <div class="vx-col w-full">
                    <div class="mt-8 flex flex-wrap items-center justify-end">
                        <vs-button class="ml-auto mt-2" @click="submit">Save Changes</vs-button>
                        <vs-button @click="$router.push({name:'ProductList'})" class="ml-4 mt-2" type="border"
                                   color="warning">
                            Cancel
                        </vs-button>
                    </div>
                </div>
            </div>
        </vx-card>
    </div>

</template>

<script>
    import vSelect from 'vue-select'

    export default {
        components: {
            vSelect,
        },
        data() {
            return {
                id: 0,
                files: [],
                types: [],
                err: 0,
                errors_image: null,
                //Form data
                form: {
                    code: '',
                    name: '',
                    price: 0,
                    category_id: 1,
                    package_id: 1,
                    materials: '',
                    weaving: '',
                    info: '',
                    size_l: 0,
                    size_w: 0,
                    size_h: 0,
                    ctn_qty: 0,
                    ctn_l: 0,
                    ctn_w: 0,
                    ctn_h: 0,
                    images: [],
                },
            }
        },
        methods: {
            removeImageStorage(index) {
                this.errors_image = null;
                this.form.images.splice(index, 1);
            },
            removeImage(index) {
                this.errors_image = null;
                this.files.splice(index, 1);
            },
            changeImages(e) {
                this.errors_image = null;
                let f = e.target.files;
                for (let i = 0; i < f.length; i++) {
                    let reader = new FileReader();
                    this.err = 0;
                    reader.readAsDataURL(f[i]);
                    reader.onload = evt => {
                        let img = new Image();
                        img.onload = () => {
                            if ((img.width == 1020 && img.height == 750) || (img.width == 1020 && img.height == 500) || (img.width == 710 && img.height == 710)) {
                                if ((img.width == 1020 && img.height == 750)) {
                                    this.types.push(1);
                                }
                                if ((img.width == 1020 && img.height == 500)) {
                                    this.types.push(2);
                                }
                                if ((img.width == 710 && img.height == 710)) {
                                    this.types.push(3);
                                }
                                this.files.push(f[i]);
                            } else {
                                this.err++;
                            }
                        }
                        // console.log(evt.target.result);
                        img.src = evt.target.result;
                    }
                }
            },
            set_image(img) {
                return URL.createObjectURL(img);
            },
            submit() {
                let total_images = this.files.length + this.form.images.length;
                if (total_images < 3) {
                    this.err = 0;
                    return this.errors_image = 'Not enough images. Please check it .';
                }
                // if (this.types.includes(1) !== true || this.types.includes(2) !== true || this.types.includes(3) !== true) {
                //     this.err = 0;
                //     return this.errors_image = 'Not enough images size. Please check it .';
                // }
                let formData = new FormData()
                for (let i = 0; i < this.files.length; i++) {
                    formData.append('images[]', this.files[i]);
                    formData.append('types[]', this.types[i]);
                }
                formData.append('images_old', JSON.stringify(this.form.images));

                // formData.append('images[]', this.form.images)
                formData.append('name', this.form.name)
                formData.append('code', this.form.code)
                formData.append('category_id', this.form.category_id)
                formData.append('package_id', this.form.package_id)
                formData.append('color', this.form.color)
                formData.append('price', this.form.price)
                formData.append('materials', this.form.materials)
                formData.append('weaving', this.form.weaving || '')
                formData.append('info', this.form.info || '')
                formData.append('size_l', this.form.size_l)
                formData.append('size_w', this.form.size_w)
                formData.append('size_h', this.form.size_h)

                //Container
                formData.append('ctn_qty', this.form.ctn_qty)
                formData.append('ctn_l', this.form.ctn_l)
                formData.append('ctn_w', this.form.ctn_w)
                formData.append('ctn_h', this.form.ctn_h)
                formData.append('_method', 'put')
                this.$store
                    .dispatch("product/UPDATE_PRODUCT", {id: this.id, params: formData})
                    // go to which page after successfully login
                    .then((res) => {
                            this.$vs.notify({
                                title: 'Success',
                                text: 'Product updated successfully!',
                                color: 'success',
                                iconPack: 'feather',
                                icon: 'icon-check',
                                position: 'top-right',
                            });
                            this.$router.push({name: 'ProductList'});
                        }
                    )
                ;
            },
        },
        computed: {
            categories() {
                return this.$store.state.product.categories;
            },
            packages() {
                return this.$store.state.product.packages;
            },
            errors() {
                return this.$store.state.product.errors;
            },
        },
        created() {
            this.$store.dispatch('product/FETCH_PRODUCT', this.$route.params.id).then(data => {
                this.form = data.data;
                this.id = this.$route.params.id
            }).catch(err => {
                console.error(err)
            })
        }
    }
</script>

<style lang="scss">
    #page-user-list {
        .user-list-filters {
            .vs__actions {
                position: absolute;
                right: 0;
                top: 50%;
                transform: translateY(-58%);
            }
        }
    }

    div.required > label {
        color: red;
    }
</style>
