
import React, { Component } from "react";
import {
  Image,
  ScrollView,
  StyleSheet,
  View,
  Text,
} from 'react-native';

import FoodItem from './FoodItem.js'


import { restaurant_url, img_url } from '../API.js'


class Restaurant extends Component {

  constructor() {
    super();
    this.state = {
      category: '',
      name: '',
      food_items: [
      ],
      image_url: '',
      cart_ref: null
    };
  }


  componentDidMount() {

    this.updateRestaurant()
  }

  showName() {
    return (
      <Text style={styles.heading}>{this.state.name}</Text>
    )
  }


  showCategory() {
    return (
      <Text style={styles.sub_heading}>{this.state.category}</Text>
    )
  }

  viewFoodItems() {
    // console.log(this.state.food_items)
    return this.state.food_items.map((prop, key) => {
      return (
        <FoodItem food={prop} key={key} />
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



  updateRestaurant() {

    fetch(restaurant_url + this.props.route.params.id, {
      method: 'GET',
    }).then(response => response.json())
      .then(data => {
        if (data) {
          // console.log(data.restaurant)
          this.setState({
            food_items: data.foods,
            name: data.restaurant.name,
            image_url: img_url + data.restaurant.image,
            category: data.restaurant.category
          })
          // console.log(this.state.image_url)
        }

      })
  }

  render() {

    return (

      <View
        style={{
          flex: 1,
          alignItems: 'center',
          flexDirection: 'column',
          backgroundColor: '#fff',
        }}
      >

            <Image
                style={styles.restaurant_img}
                source={{
                    uri: this.state.image_url ? this.state.image_url : img_url+'blank.png',
                }}
            />

        {this.showName()}
        {this.showCategory()}


        <ScrollView style={{ width: "100%" }} contentContainerStyle={{ flexGrow: 1, alignItems: 'center' }}>
          {this.viewFoodItems()}
        </ScrollView>

      </View>

    );

  }
}

const styles = StyleSheet.create({
  input: {
    height: 40,
    margin: 12,
    borderWidth: 1,
    width: 250,
    borderRadius: 10,
    borderColor: "#888",
    padding: 10,
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
  food_img: {
    height: 100,
    width: 100,
    borderRadius: 100,
    paddingRight: 40
  },
  restaurant: {
    display: 'flex',
    flexDirection: 'row',
    width: 400,
    padding: 5
  },
  restaurant_img: {
    height: 100,
    width: "90%",
    borderRadius: 10,
    marginBottom: 10
  },
  food_text: {
    paddingLeft: 20,
    display: 'flex',
    flexDirection: 'column',
    justifyContent: 'center',
  },
  food_text_sub_heading: {
    fontSize: 30,
    fontWeight: 'bold',
  },
  food_text_sub_heading: {
    fontWeight: 'bold'
  }
});



export default Restaurant