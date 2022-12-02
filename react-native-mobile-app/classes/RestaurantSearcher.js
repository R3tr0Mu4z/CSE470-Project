
import React, { Component } from "react";
import {
  Image,
  ScrollView,
  StyleSheet,
  TouchableOpacity,
  View,
  Text,
  TextInput,
  Pressable
} from 'react-native';

import { search_url, img_url } from '../API.js'

class RestaurantSearcher extends Component {

  constructor() {
    super();
    this.state = {
      query: "",
      cart_ref: null,
      restaurants: [
      ]
    };
  }

  searchRestaurants() {

    let formData = new FormData();

    formData.append('search', this.state.query);
    fetch(search_url, {
      method: 'POST',
      body: formData,
    }).then(response => response.json())
      .then(data => {

        // console.log(data)
        this.setState({ restaurants: data })

      })
  }

  componentDidMount() {
    this.searchRestaurants()
  }

  viewRestaurant(id) {
    this.props.navigation.navigate('Restaurant', {
      id: id
    })
  }


  listSearchResults() {
    // console.log(this.state.restaurants)
    return this.state.restaurants.map((prop, key) => {
      return (
        <TouchableOpacity style={styles.restaurant} key={key} onPress={() => this.viewRestaurant(prop['restaurant_id'])}>
          <Image
            style={styles.restaurant_img}
            source={{
              uri: img_url + prop['image'],
            }}
          />
          <View style={styles.restaurant_text}>

            <Text style={styles.restaurant_text_heading}>{prop['name']}</Text>
            <Text style={styles.restaurant_text_sub_heading}>
              <Text style={styles.bold}>
                Category :
              </Text>
              {prop['category']}</Text>
          </View>
        </TouchableOpacity>
      )
    })
  }

  componentDidUpdate(prevProps) {
    // console.log("HERE")
    if (prevProps.cart_ref !== this.props.cart_ref) {
      // console.log("CART REF RES")
      this.setState({ cart_ref: this.props.cart_ref });
    }
  }

  render() {

    // console.log(this.props, 'restaurant searcher')

    return (

      <View
        style={{
          flex: 1,
          alignItems: 'center',
          flexDirection: 'column',
          backgroundColor: '#fff',
        }}
      >


        <TextInput
          style={styles.input}
          placeholder="Type here"
          onChangeText={(text) => this.setState({ query: text })}
        />
        <Pressable
          onPress={() => this.searchRestaurants()}
          style={styles.button}
        >
          <Text style={styles.button_text}>Search</Text>
        </Pressable>

        <ScrollView style={{ width: "100%" }} contentContainerStyle={{ flexGrow: 1, alignItems: 'center' }}>
          {this.listSearchResults()}
        </ScrollView>

      </View>

    );

  }
}

const styles = StyleSheet.create({
  input: {
    height: 50,
    margin: 12,
    borderWidth: 1,
    width: "90%",
    borderRadius: 50,
    borderColor: "#dbdbdb",
    padding: 10,
    backgroundColor: "#fff"
  },
  heading: {
    fontSize: 20,
    fontWeight: 'bold'
  },
  optext: {
    fontSize: 14,
    fontWeight: 'bold',
    paddingTop: 10
  },
  restaurant_img: {
    height: 80,
    width: 80,
    borderRadius: 80,
    paddingRight: 40
  },
  restaurant: {
    display: 'flex',
    flexDirection: 'row',
    alignItems: 'center',
    width: "90%",
    padding: 10,
    backgroundColor: "#fff",
    padding: 20,
    width: "90%",
    margin: 5,
    borderRadius: 20,
    borderWidth: 2,
    borderColor: "#ffe680"
  },
  restaurant_text: {
    paddingLeft: 20,
    display: 'flex',
    flexDirection: 'column',
    justifyContent: 'center',
  },
  restaurant_text_sub_heading: {
    fontSize: 10,
  },
  bold: {
    fontWeight: 'bold'
  },

  button: {
    backgroundColor: "#f5c505",
    padding: 10,
    width: "60%",
    marginBottom: 20,
    borderRadius: 20
  },
  button_text: {
    textAlign: 'center',
    color: "#fff",
    fontWeight: 'bold'
  },
  main: {
    backgroundColor: "#fffae6"
  },
});



export default RestaurantSearcher