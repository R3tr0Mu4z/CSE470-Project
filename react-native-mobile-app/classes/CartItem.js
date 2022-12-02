import React, { Component } from 'react';
import {
  Image,
  StyleSheet,
  View,
  Text
} from 'react-native';
import { connect } from 'react-redux';
import CartContext from '../context/CartContext'

import { food_url, img_url } from '../API.js'

class CartItem extends Component {
  static contextType = CartContext
  constructor(props) {
    super();
    this.state = {
      food_id: null,
      image: null,
      price: null,
      name: null,
      quantity: 0,
      name: "",
    };



  }


  getFoodItemDetails(id) {

    fetch(food_url + id, {
      method: 'GET',
    }).then(response => response.json())
      .then(data => {
        if (data) {
          console.log(data)
          this.setState({
            image: data.image,
            category: data.category,
            image: img_url + data.image,
            price: data.price,
            name: data.name
          })
        }

      })
  }


  componentDidMount() {
    this.setState({ food_id: this.props.data.id, quantity: this.props.data.quantity })
    this.getFoodItemDetails(this.props.data.id)
  }




  render() {

    console.log(this.state, 'food state')

    return (
      <View style={styles.restaurant}>
        <Image
          style={styles.food_img}
          source={{
            uri: this.state.image,
          }}
        />
        <View style={styles.food_right}>

          <View style={styles.food_text}>

            <Text style={styles.food_text_heading}>{this.state.name} x{this.state.quantity}</Text>
            <Text style={styles.food_text_sub_heading}><Text style={styles.food_text_sub_heading}>Category : </Text> {this.state.category}</Text>
            <Text style={styles.food_text_sub_heading}><Text style={styles.food_text_sub_heading}>Cost : </Text> {this.state.price * this.state.quantity} Tk</Text>
          </View>
        </View>
      </View>

    )

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
    height: 80,
    width: 80,
    borderRadius: 80,
    paddingRight: 40
  },
  restaurant: {
    display: 'flex',
    flexDirection: 'row',
    width: 400,
    padding: 5
  },
  food_text: {
    paddingLeft: 20,
    display: 'flex',
    flexDirection: 'column',
    justifyContent: 'center',
  },
  food_text_sub_heading_bold: {
    fontSize: 10,
    fontWeight: 'bold',
  },
  food_text_sub_heading: {
    fontSize: 10,
    marginBottom: 5
  },

});



function mapStateToProps(state) {
  return {
    token: state.token
  }
}

function mapDispatchToProps(dispatch) {
  return {
    setToken: (token) => dispatch({ type: 'SETTOKEN', token: token }),
  }
}


export default connect(mapStateToProps, mapDispatchToProps)(CartItem)