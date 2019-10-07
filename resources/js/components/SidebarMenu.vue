<template>
    <v-list dense>
        <template v-for="item in menu">
          <v-list-group
            v-if="item.children"
            :key="item.text"
            v-model="item.model"
            :prepend-icon="item.icon"
            :append-icon="item.model ? item['icon-append-up'] : item['icon-append-down']"
          >
            <template v-slot:activator>
              <v-list-item>
                <v-list-item-content>
                  <v-list-item-title>
                    {{ item.text }}
                  </v-list-item-title>
                </v-list-item-content>
              </v-list-item>
              
            </template>
            <v-list-item
              v-ripple
              style="cursor: pointer"
              v-for="(child, i) in item.children"
              :key="i"
              @click.native="redirect(child.url)"
            >
              <v-list-item-action v-if="child.icon">
                <v-icon>{{ child.icon }}</v-icon>
              </v-list-item-action>
              <v-list-item-content>
                <v-list-item-title>
                  {{ child.text }}
                </v-list-item-title>
              </v-list-item-content>
            </v-list-item>
          </v-list-group>
          <v-list-item
            v-else
            v-ripple
            style="cursor: pointer"
            :key="item.text"
            @click="redirect(item.url)"
          >
            <v-list-item-action>
              <v-icon>{{ item.icon }}</v-icon>
            </v-list-item-action>
            <v-list-item-content>
              <v-list-item-title>
                {{ item.text }}
              </v-list-item-title>
            </v-list-item-content>
          </v-list-item>
        </template>
    </v-list>
</template>

<script>
export default {
  props: {
    menu: {
      type: Array,
      default: () => []
    }
  },
  data () {
      return {
          
      }
  },
  methods: {
    redirect(url) {
      if (url == '/logout') {
        const cookies = this.$cookies.keys()
        cookies.forEach(cookie => this.$cookies.remove(cookie))
        this.$router.push('/login')
      } else {
        this.$router.push({name: url})
      }
    }
  }
}
</script>

<style lang="scss" scoped>

</style>