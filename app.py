from flask import Flask, request, jsonify
import joblib
import pandas as pd

app = Flask(__name__)

# Load models once at startup
try:
    model_cost_maintenance = joblib.load('Maintenace_Cost.pkl')
    model_cost_production = joblib.load('Production_Cost.pkl')
except Exception as e:
    print(f"Error loading models: {e}")
    model_cost_maintenance = None
    model_cost_production = None

@app.route('/cost_maintenance', methods=['POST'])
def predict_cost_maintenance():
    if model_cost_maintenance is None:
        return jsonify({'error': 'Model not loaded'}), 500

    try:
        data = request.get_json()
        Menge = data.get('Menge', 0)
        Nettpreis = data.get('Nettpreis', 0)
        features = pd.DataFrame([[Menge, Nettpreis]], columns=['Menge', 'Nettpreis'])
        prediction = model_cost_maintenance.predict(features)
        response = {'prediction': prediction.item()}
    except Exception as e:
        response = {'error': str(e)}
    return jsonify(response)

@app.route('/predict_cost_production', methods=['POST'])
def predict_cost_production():
    if model_cost_production is None:
        return jsonify({'error': 'Model not loaded'}), 500

    try:
        data = request.get_json()
        Menge = data.get('Menge', 0)
        WertBB = data.get('WertBB', 0)
        Gesamtvbrwert = data.get('Gesamtvbrwert', 0)
        features = pd.DataFrame([[Menge, WertBB, Gesamtvbrwert]], columns=['Menge', 'WertBB', 'Gesamtvbrwert'])
        prediction = model_cost_production.predict(features)
        response = {'prediction': prediction.item()}
    except Exception as e:
        response = {'error': str(e)}
    return jsonify(response)

if __name__ == '__main__':
    app.run(debug=True)
