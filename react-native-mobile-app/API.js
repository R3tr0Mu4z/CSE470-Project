const base_url = 'http://192.168.1.2:8000'
const place_url = base_url + '/api/place-order?token='
const food_url = base_url + '/api/get-food/'
const img_url = base_url + '/images/'
const signup_url = base_url + '/api/auth/register/'
const login_url = base_url + '/api/auth/login/'
const update_url = base_url + '/api/auth/update/'
const search_url = base_url + '/api/search/'
const restaurant_url = base_url + '/api/get-restaurant/'
const orders_url = base_url + '/api/get-orders/'
const order_url = base_url + '/api/get-order/'

export { place_url, food_url, img_url, signup_url, login_url, search_url, restaurant_url, orders_url, order_url, update_url }