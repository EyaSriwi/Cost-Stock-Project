from flask import Flask, request, jsonify
import joblib
import numpy as np

app = Flask(__name__)

# Load the trained models
model_cost_maintenance = joblib.load("model_cost_maintenance.pkl")
model_cost_production = joblib.load("model_cost_production.pkl")

@app.route('/predict_cost_maintenance', methods=['POST'])
def predict_cost_maintenance():
    # Retrieve the data sent by the clients
    data = request.get_json()

    # Extract feature values from the request
    menge = data['Menge']
    nettpreis = data['Nettpreis']
    sicherheitsbestand = data['Sicherheitsbestand']
    standort = data['Standort']
    artikel_zustand = data['Artikel Zustand']

    # Prepare the feature array for prediction
    features = np.array([[menge, nettpreis, sicherheitsbestand, standort, artikel_zustand]])

    # Make the prediction
    prediction = model_cost_maintenance.predict(features)

    # Return the prediction as the response
    response = {'prediction': prediction.item()}
    return jsonify(response)

@app.route('/predict_cost_production', methods=['POST'])
def predict_cost_production():
    # Retrieve the data sent by the client
    data = request.get_json()

    # Extract feature values from the request
    menge = data['Menge']
    wertbb = data['WertBB']

    # Prepare the feature array for prediction
    features = np.array([[menge, wertbb]])

    # Make the prediction
    prediction = model_cost_production.predict(features)

    # Return the prediction as the response
    response = {'prediction': prediction.item()}
    return jsonify(response)

if __name__ == '__main__':
    app.run(debug=True)
