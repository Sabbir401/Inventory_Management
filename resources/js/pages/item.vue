<template>
  <div class="col-lg-12 grid-margin stretch-card">
    <div class="d-flex justify-content-end">
      <button type="button" class="btn btn-dark my-2" @click="logout">
        Logout
      </button>
    </div>

    <div class="card mb-3">
      <div class="card-body">
        <div class="d-flex">
          <div class="mr-auto p-2">
            <div class="row">
              <h4 class="card-title m-2">Item Information</h4>
            </div>
          </div>
        </div>
        <form
          class="forms-sample"
          enctype="multipart/form-data"
          @submit.prevent="submitHandler"
        >
          <div class="row">
            <div class="form-group col-lg-4">
              <label for="exampleInputUsername1">Item Name</label>
              <input
                type="text"
                class="form-control"
                id="exampleInputUsername1"
                v-model="form.name"
              />
            </div>
            <div class="form-group col-lg-4">
              <label for="exampleInputEmail1">Quantity</label>
              <input
                type="text"
                class="form-control"
                id="exampleInputEmail1"
                placeholder=""
                v-model="form.quantity"
              />
            </div>
            <div class="form-group col-lg-4">
              <label for="exampleInputEmail1">Image</label>
              <input
                type="file"
                class="form-control"
                id="exampleInputEmail1"
                @change="getImage"
              />
            </div>
          </div>
          <div class="form-group">
            <label for="exampleFormControlTextarea1">Description</label>
            <textarea
              class="form-control"
              id="exampleFormControlTextarea1"
              rows="3"
              v-model="form.description"
            ></textarea>
          </div>
          <button type="submit" class="btn btn-primary mr-2">Save</button>
          <button class="btn btn-danger" type="reset">Reset</button>
        </form>
      </div>
    </div>

    <div class="card">
      <div class="card-body">
        <div class="d-flex justify-content-end">
          <div class="pb-2">
            <input
              type="text"
              class="form-control"
              id="exampleInputUsername1"
              placeholder="Search..."
            />
          </div>
        </div>

        <div class="table-responsive">
          <table class="table table-hover table-bordered">
            <thead>
              <tr>
                <th>S/N</th>
                <th>Name</th>
                <th>Description</th>
                <th>Quantity</th>
                <th>Image</th>
                <th>Operation</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(item, index) in items" :key="item.id">
                <td>{{ index + 1 }}</td>
                <td>{{ item.Name }}</td>
                <td>{{ item.Description }}</td>
                <td>{{ item.quantity }}</td>
                <td>
                  <img :src="item.image_url" height="50px" width="50px" />
                </td>
                <td>
                  <img src="/storage/app/uploads/1712242126_artisan_logo-removebg-preview.png" height="50px" width="50px" />
                </td>
                <td>
                  <button
                    class="btn btn-success mr-2"
                    @click="editHandler(item.id)"
                  >
                    Show
                  </button>
                  <button class="btn btn-danger" @click="deleteItem(item.id)">
                    Delete
                  </button>
                </td>
              </tr>
            </tbody>
          </table>
          <br />
          <!-- <Bootstrap5Pagination
              :data="stores"
              @pagination-change-page="getData"
            /> -->
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { useRoute } from "vue-router";
import { ref, onMounted, reactive, watch } from "vue";
import { useStore } from "vuex";

export default {
  setup() {
    const route = useRoute();
    const invid = parseInt(route.params.id);

    const store = useStore();
    var flag = 0

    const selecteddata = ref(null);

    const form = reactive({
      inventoryId: invid,
      name: "",
      description: "",
      quantity: "",
      image: null,
    });

    watch(
      () => selecteddata.value,
      (newVal) => {
        form.inventoryId = newVal.id;
        form.name = newVal.Name;
        form.description = newVal.Description;
        form.quantity = newVal.quantity;
      }
    );

    const items = ref("");

    function logout() {
      store.dispatch("removeToken");
      route.push({ name: "Login" });
    }

    const editHandler = async (id) => {
      try {
        const response = await axios.get(`/api/item/${id}/edit`);
        selecteddata.value = response.data;
        flag = 1;
        console.log(selecteddata);
      } catch (err) {
        console.error("Error fetching store data for editing:", err);
      }
    };

    const deleteItem = async (id) => {
      try {
        const response = await axios.delete(`/api/item/${id}`);
        getData();
      } catch (err) {
        console.error("Error fetching store data for editing:", err);
      }
    };

    const getData = async () => {
      try {
        // const res = await axios.get("/api/get-session-data");
        // const userID = res.data.userId;

        const responseItem = await axios.get(`/api/item/${form.inventoryId}`);
        items.value = responseItem.data;
      } catch (error) {
        console.error("Error fetching data");
      }
    };

    const resetForm = () => {
      Object.keys(form).forEach((key) => {
        form[key] = "";
      });
    };

    const update = async () => {
      try {
        const response = await axios.put(`/api/item/${form.inventoryId}`, form);
        if (response.data.success) {
          alert("Successfully Updated");
          resetForm();
          getData();
        }
      } catch (error) {
        console.error("Error updating store:", error);
      }
    };


    const getImage = (e) => {
      //   file.value = e.target.files[0];
      form.image = e.target.files[0];
    };

    const submit = async (e) => {
      const config = {
        headers: {
          "Content-Type": "multipart/form-data",
        },
      };
      console.log(form.image);
      let data = new FormData();
      data.append("file", form.image);

      for (const key in form) {
        if (Object.hasOwnProperty.call(form, key)) {
          const value = form[key];
          data.append(key, value);
        }
      }

      try {
        const response = await axios.post("/api/item", data, config);
        console.log(response.data);
        alert("Successfully Inserted");
        resetForm();
        getData();
      } catch (error) {
        console.error("Error uploading image:", error);
      }
    };


    const submitHandler = () => {
      if(flag == 1){
        update();
        flag = 0;
      }else{
        submit();
      }
    };

    onMounted(() => getData());

    return {
      logout,
      form,
      submit,
      editHandler,
      deleteItem,
      route,
      getImage,
      items,
      selecteddata,
      submitHandler,
    };
  },
};
</script>
