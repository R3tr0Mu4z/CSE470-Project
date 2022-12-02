
import React, { Component } from "react";
import {
    ScrollView,
    Button,
    StyleSheet,
    TouchableOpacity,
    View,
    Modal,
    Text
} from 'react-native';
import CartItem from './CartItem.js'
import { connect } from 'react-redux';
import { place_url } from '../API.js'
import Icon from 'react-native-vector-icons/FontAwesome';
import { showMessage, hideMessage } from "react-native-flash-message";

class Cart extends Component {

    constructor() {
        super();
        this.state = {
            items: [],
            args: {},
            modalVisible: false
        }
    }

    addFoodToCart = (food) => {

        let items = this.state.items


        console.log(food, 'food')

        removeOtherRestaurantFoods = false


        if (items.length > 0) {
            items.forEach(v => {
                console.log(v['restaurant'], "v['restaurant']")
                console.log(food['restaurant'], "food['restaurant']")
                if (v['restaurant'] != food['restaurant']) {
                    removeOtherRestaurantFoods = true
                }
            })
        }

        if (removeOtherRestaurantFoods) {
            showMessage({
                message: "You can order from one restaurant at a time",
                type: "danger",
            });
            items = []
        }

        let exist = false

        items.forEach(v => {
            if (v['id'] == food['food_id']) {
                exist = true
                v['quantity'] = v['quantity'] + 1
            }
        })



        if (!exist) {
            // console.log("NOT hERE")
            var item = {}
            item['id'] = food['food_id']
            item['quantity'] = 1
            item['restaurant'] = food['restaurant']
            items.push(item)
        }

        this.setState({ items: items })
    }


    removeFromCart = (food, entire = false) => {
        let items = this.state.items
        items.forEach((v, index, object) => {
            if (v['id'] == food) {
                if (v['quantity'] > 0) {
                    v['quantity'] = v['quantity'] - 1
                    if (entire) {
                        v['quantity'] = 0
                    }
                }

            }

        })
        this.setState({ items: items })
    }

    getQuantity = (food_id) => {
        console.log("GET Quantity")
        let quantity = 0
        this.state.items.forEach(v => {
            if (v['id'] == food_id) {
                quantity = v['quantity']
            }

        })
        return quantity
    }

    listCartItems() {
        // console.log(this.state.food_items)
        return this.state.items.map((prop, key) => {
            if (prop['quantity'] > 0) {
                return (
                    <View key={key} style={{display: 'flex', flexDirection: 'row'}}>
                        <CartItem data={prop} />
                        <TouchableOpacity onPress={() => this.removeFromCart(prop.id, true)}>
                            <Text style={styles.cart_button_wrapper}>
                                <Icon name="remove" size={22} color="#000" style={
                                    {
                                        position: 'relative',
                                        right: 20
                                    }
                                } />;
                            </Text>
                        </TouchableOpacity>
                    </View>
                )
            }
        })
    }

    placeOrder() {

        var order = []
        var items = this.state.items

        items.forEach(v => {
            if (v['quantity'] > 0) {
                order.push(v)
            }
        })
        order = JSON.stringify(order)
        let formData = new FormData();

        formData.append('order', order);
        console.log(order, 'order')
        fetch(place_url + this.props.token, {
            method: 'POST',
            body: formData,
        }).then(response => response.json())
            .then(response => {
                if (response.type == 'success') {
                    this.setState({ items: [], modalVisible: false })
                    showMessage({
                        message: response.message,
                        type: response.type,
                    });
                }
            })
        //   .then(response => console.log(response))
    }



    componentDidUpdate(prevProps) {
        if (prevProps.args !== this.props.args) {
            this.setState({ args: this.props.args });
            let args = this.props.args
            if (args?.type) {

                if (args.type == 'add') {
                    this.addFoodToCart(args['food'])
                }

                if (args.type == 'remove') {
                    this.removeFromCart(args['food'])
                }
            }
        }
    }

    cartButton() {
        console.log(this.state.items.length, 'cart button')
        if (this.state.items.length > 0) {
            return (
                <TouchableOpacity style={styles.cart_button} onPress={() => this.setState({ modalVisible: this.state.modalVisible ? false : true })}>
                    <Text style={styles.cart_button_wrapper}>
                        <Icon name="shopping-cart" size={22} color="#fff" />;
                    </Text>
                </TouchableOpacity>
            )
        }
    }


    orderButton() {
        let show = false

        this.state.items.forEach(v => {
            if (v.quantity > 0){
                show = true
            }
        }) 

        if (show) {
            return (
                <Button title="Place order" style={{ height: 80 }} onPress={() => this.placeOrder()} />
            )
        }
    }


    render() {

        console.log(this.props.token, ' cart state')

        return (

            <>
                <Modal
                    animationType="slide"
                    transparent={true}
                    visible={this.state.modalVisible}
                    onRequestClose={() => {
                        this.setState({ modalVisible: false });
                    }}
                >
                    <ScrollView style={{ backgroundColor: "#fff", height: "100%" }}>

                        <View>
                            <Text style={styles.heading}>
                                Your Cart
                            </Text>
                            {this.listCartItems()}
                        </View>
                        {this.orderButton()}
                    </ScrollView>
                </Modal>
                {this.cartButton()}
            </>
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
        fontWeight: 'bold',
        textAlign: 'left',
        padding: 10
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
    },
    cart_button: {
        position: 'absolute', right: 30, bottom: 60,
        backgroundColor: "#f5c505",
        height: 50,
        width: 50,
        borderRadius: 20,
        display: 'flex',
        flexDirection: 'column',
        justifyContent: 'center',
    },
    cart_button_wrapper: {
        textAlign: 'center'
    }
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


export default connect(mapStateToProps, mapDispatchToProps, null, { forwardRef: true })(Cart)