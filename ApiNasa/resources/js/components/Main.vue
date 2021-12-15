<template>
    <section class="content">
        <v-app>
            <v-data-table
                :headers="headers"
                :items="rows"
                :sort-by="['title', 'geometry.0.date']"
                :sort-desc="[false, false]"
                :footer-props="{
                'items-per-page-options': [5, 10, 20]
                }"
                class="elevation-1"
            >
                <template v-slot:top>
                    <v-container fluid>
                        <v-row>
                            <v-col cols="6">
                                <v-row class="pa-6">
                                    <v-select
                                        :items="categoriesList"
                                        v-model="categoriesFilterValue"
                                        label="Type of Disaster"
                                    ></v-select>
                                </v-row>
                            </v-col>
                        </v-row>
                    </v-container>
                </template>
                <template #item.geometry.0.coordinates="{ value }">
                    <div v-if="value[0][0] != null">
                        <a target='blank' :href="'http://www.google.com/maps/place/' + value[0].slice(0,1).reverse()">
                            {{ value[0][0] }}
                        </a>
                    </div>
                    <div v-else>
                        <a target='blank' :href="'http://www.google.com/maps/place/' + value.slice().reverse()">
                            {{ value }}
                        </a>
                    </div>
                </template>
                <template #item.geometry.0.date="{ value }">
                    <p>
                        {{ value.slice(0,10) }}
                    </p>
                </template>
            </v-data-table>
        </v-app>
    </section>
</template>

<script>
export default {
    data () {
        return {
            headers: [
                {
                    text: 'Name of Disaster',
                    align: 'start',
                    value: 'title',
                    width: "400px"
                },
                { text: 'Date', value: 'geometry.0.date', width: "200px" },
                { text: 'Coordinates', value: 'geometry.0.coordinates', width: "200px" },
                { text: 'Categories', value: 'categories.0.title', width: "200px", filter: this.categoryFilter },
            ],
            rows: [],
            categoriesFilterValue: null,
            categoriesList: [
                {text: "All", value: null},
                {text: "Drought", value: 'Drought'},
                {text: "Dust and Haze", value: 'Dust and Haze'},
                {text: "Earthquakes", value: 'Earthquakes'},
                {text: "Floods", value: 'Floods'},
                {text: "Landslides", value: 'Landslides'},
                {text: "Manmade", value: 'Manmade'},
                {text: "Sea and Lake Ice", value: 'Sea and Lake Ice'},
                {text: "Severe Storms", value: 'Severe Storms'},
                {text: "Snow", value: 'Snow'},
                {text: "Temperature Extremes", value: 'Temperature Extremes'},
                {text: "Volcanoes", value: 'Volcanoes'},
                {text: "Water Color", value: 'Water Color'},
                {text: "Wildfires", value: 'Wildfires'},
            ],
        }
    },
    methods: {
        loadEvents(){
            axios.get("/ApiNasa").then(({ data }) => (this.rows = data.data.events));
        },
        categoryFilter(value) {
            if (!this.categoriesFilterValue) {
                return true;
            }

            return value === this.categoriesFilterValue;
        }
    },
    created() {
        this.loadEvents();
    }
}

</script>
