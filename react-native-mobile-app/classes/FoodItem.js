
import React, { Component } from "react";
import {
    Image,
    Platform,
    ScrollView,
    Button,
    StyleSheet,
    TouchableOpacity,
    View,
    BackHandler,
    Keyboard,
    StatusBar,
    Modal,
    Text,
    RefreshControl,
    TextInput
} from 'react-native';
import CartContext from '../context/CartContext'

import { img_url } from '../API.js'


class FoodItem extends Component {
    static contextType = CartContext
    constructor(props) {
        super();
        this.state = {
            food_id: 1,
            category: 'thai',
            name: 'Food Name',
            price: 200,
            quantity: 0,
            image: '',
            quantity: 0,
            restaurant: 0
        };
    }

    componentDidMount() {
        let food = this.props.food
        this.setState({
            category: food.category,
            food_id: food.food_id,
            image: img_url + food.image,
            name: food.name,
            price: food.price,
            restaurant: food.restaurant
        })

        this.setState({ quantity: this.context.getQuantity(this.props['food']['food_id']) })
    }

    showName() {
        return (
            <Text style={styles.food_text_heading}>{this.state.name}</Text>
        )
    }


    showCategory() {
        return (
            <Text style={styles.food_text_sub_heading}><Text style={styles.food_text_sub_heading_bold}>Category: </Text>{this.state.category}</Text>
        )
    }

    showPrice() {
        return (
            <Text style={styles.food_text_sub_heading}>{this.state.price} Tk</Text>
        )
    }

    showImage() {
        return (
            <Image
                style={styles.food_img}
                source={{
                    uri:  this.state.image ? this.state.image : img_url+'blank.png'
                }}
            />
        )
    }

    sendArgsToCart = (args) => {
        if (args.type == 'add') {
            this.context.addFoodToCart({
                food_id: this.state.food_id,
                quantity: this.state.quantity,
                restaurant: this.state.restaurant
            })
            this.setState({ quantity: this.state.quantity + 1 })
        } else {
            this.context.removeFromCart(this.state.food_id)
            this.setState({ quantity: this.state.quantity - 1 > 0 ? this.state.quantity - 1 : 0 })
        }
    }


    componentDidUpdate(prevProps) {
        // console.log("HERE")
        if (prevProps.cart_ref !== this.props.cart_ref) {
            this.setState({ cart_ref: this.props.cart_ref });
        }
    }

    getItemQuantityFromCart = (food_id) => {
        if (this.context != null) {
            let quantity = this.context.getQuantity(this.state.food_id)
            if (quantity) {
                return quantity >= 1 ? quantity : 0
            } else {
                return 0
            }
        }
        return 0
    }


    render() {
        return (

            <View style={styles.restaurant}>
                {this.showImage()}
                <View style={styles.food_right}>

                    <View style={styles.food_text}>

                        {this.showName()}
                        {this.showCategory()}
                        {this.showPrice()}
                        <View style={styles.food_buttons}>
                            <TouchableOpacity onPress={() => this.sendArgsToCart({ type: 'add', food: this.state })}>
                                <View style={styles.plus}>
                                    <Text style={styles.plusminustext}>
                                        +
                                    </Text>
                                </View>
                            </TouchableOpacity>
                            <Text>{this.state.quantity}</Text>
                            <TouchableOpacity onPress={() => this.sendArgsToCart({ type: 'remove', food: this.state })}>
                                <View style={styles.minus}>
                                    <Text style={styles.plusminustext}>
                                        -
                                    </Text>
                                </View>
                            </TouchableOpacity>
                        </View>
                    </View>
                </View>
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
    food_buttons: {
        display: 'flex',
        flexDirection: 'row'
    },
    plus: {
        backgroundColor: "#ffe680",
        height: 30,
        width: 30,
        display: 'flex',
        alignItems: 'center',
        flexDirection: 'row',
        justifyContent: 'center',
        borderRadius: 20,
        marginRight: 20,
    },
    minus: {
        backgroundColor: "#ffe680",
        height: 30,
        width: 30,
        display: 'flex',
        alignItems: 'center',
        flexDirection: 'row',
        justifyContent: 'center',
        borderRadius: 20,
        marginLeft: 20,
    }
});



export default FoodItem