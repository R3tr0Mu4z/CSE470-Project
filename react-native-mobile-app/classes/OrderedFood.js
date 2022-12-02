
import React, { Component } from "react";
import {
    Image,
    ScrollView,
    StyleSheet,
    View,
    Text,
    RefreshControl,
} from 'react-native';
import { connect } from 'react-redux';
import { order_url, img_url } from '../API.js'


class OrderedFood extends Component {
    constructor(props) {
        super();
        this.state = {
            order_id: 0,
            time: '',
            total: 0,
            order_status: '',
            foods: []

        };
    }

    componentDidMount() {
        let order = this.props.route.params.order
        this.setState({
            order_id: order.id,
            time: order.time,
            total: order.total,
            status: order.status,
            foods: order.foods,
            refreshing: false
        })
    }

    _onRefresh = () => {
        this.setState({ refreshing: true });
        this.checkStatus()
    }

    checkStatus = () => {
        fetch(order_url + this.state.order_id, {
            method: 'GET',
            headers: new Headers({
                'Authorization': 'Bearer ' + this.props.token
            }),
        }).then(response => response.json())
            .then(data => {
                this.setState({ status: data.status, refreshing: false })
            })
    }


    viewFoods() {
        return this.state.foods.map((prop, key) => {
            return (
                <View style={styles.food_item}
                    key={key}
                >
                    <Image
                        style={styles.img}
                        source={{
                            uri: img_url + prop['image'],
                        }}
                    />
                    <View style={styles.food_text}>

                        <View style={styles.fl}>
                            <Text style={styles.bold}>Name : </Text>
                            <Text style={styles.text}>{prop['name']} x{prop['quantity']}</Text>
                        </View>

                        <View style={styles.fl}>
                            <Text style={styles.bold}>Cost : </Text>
                            <Text style={styles.text}>{prop['cost']} Tk</Text>
                        </View>
                    </View>
                </View>
            )
        })
    }





    render() {
        return (

            <ScrollView style={styles.main}
                contentContainerStyle={{ flexGrow: 1, alignItems: 'center' }}
                refreshControl={
                    <RefreshControl
                        refreshing={this.state.refreshing}
                        onRefresh={this._onRefresh}
                    />
                }
            >
                <View style={styles.overview}>
                    <View style={styles.overview_item}>
                        <Text style={styles.overview_bold}>Order ID : </Text>
                        <Text style={styles.overview_text}>{this.state.order_id}</Text>
                    </View>
                    <View style={styles.overview_item}>
                        <Text style={styles.overview_bold}>Total : </Text>
                        <Text style={styles.overview_text}>{this.state.total}</Text>
                    </View>
                    <View style={styles.overview_item}>
                        <Text style={styles.overview_bold}>Status : </Text>
                        <Text style={styles.overview_text}>{this.state.status}</Text>
                    </View>
                    <View style={styles.overview_item}>
                        <Text style={styles.overview_bold}>Time : </Text>
                        <Text style={styles.overview_text}>{this.state.time}</Text>
                    </View>
                </View>
                <View style={styles.foods}>
                    <Text style={{ fontSize: 20, textAlign: 'center' }}>
                        Ordered Foods
                    </Text>
                    {this.viewFoods()}
                </View>
            </ScrollView>

        );

    }
}

const styles = StyleSheet.create({
    img: {
        height: 50,
        width: 50,
        borderRadius: 50,
        paddingRight: 0,
        margin: 20
    },
    overview: {
        backgroundColor: "#fff",
        padding: 40,
        width: "90%",
        margin: 10,
        borderRadius: 20,
        borderWidth: 2,
        borderColor: "#ffe680"
    },
    overview_item: {
        display: 'flex',
        flexDirection: 'row',
    },
    overview_bold: {
        fontWeight: 'bold',
        fontSize: 14,
    },
    foods: {
        backgroundColor: "#fff",
        padding: 40,
        width: "90%",
        margin: 10,
        borderRadius: 20,
        borderWidth: 2,
        borderColor: "#ffe680"
    },
    main: {
        backgroundColor: "#fffae6"
    },
    food_item: {
        width: "100%",
        display: 'flex',
        flexDirection: 'row',
        alignItems: 'center',
        marginBottom: 0
    },
    text: {
        fontSize: 10
    },
    bold: {
        fontSize: 10,
        fontWeight: 'bold'
    },
    fl: {
        display: 'flex',
        flexDirection: 'row'
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

export default connect(mapStateToProps, mapDispatchToProps)(OrderedFood)