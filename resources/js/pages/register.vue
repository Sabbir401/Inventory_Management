<template>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-sm-4 mt-5">
        <div class="border border-dark rounded p-4">
          <h1 class="text-center">Register</h1>
          <p class="text-danger" v-for="error in errors" :key="error">
            <span v-for="err in error" :key="err">{{ err }}</span>
          </p>
          <form @submit.prevent="register">
            <div class="from-group">
              <label for="name">Name</label>
              <input
                type="text"
                class="form-control"
                id="name"
                v-model="form.name"
              />
            </div>
            <div class="from-group">
              <label for="email">Email Address</label>
              <input
                type="email"
                class="form-control"
                id="email"
                v-model="form.email"
              />
            </div>
            <div class="from-group">
              <label for="password">Password</label>
              <input
                type="password"
                class="form-control mb-2"
                id="password"
                v-model="form.password"
              />
            </div>
            <div class="from-group">
              <label for="c_password">Confirm Password</label>
              <input
                type="password"
                class="form-control mb-2"
                id="c_password"
                v-model="form.c_password"
              />
            </div>
            <button type="submit" class="btn btn-primary">Register</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>

  <script>
import axios from "axios";
import { reactive, ref } from "vue";
import { useRouter } from "vue-router";
import { useStore } from "vuex";

export default {
  setup() {
    const router = useRouter();
    const store = useStore();

    let form = reactive({
      name: "",
      email: "",
      password: "",
      c_password: "",
    });

    let errors = ref([]);

    const register = async () => {
      await axios
        .post("/api/register", form)
        .then((res) => {
          if (res.data.success) {
            // localStorage.setItem("token", res.data.data.token);
            store.dispatch("setToken", res.data.data.token);
            store.dispatch("setUserId", res.data.userid);
            router.push({ name: "Dashboard" });
          }
        })
        .catch((e) => {
          errors.value = e.response.data.message;
        });
    };
    return {
      form,
      register,
      errors,
    };
  },
};
</script>
