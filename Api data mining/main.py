from flask import Flask, jsonify, request
import pandas as pd
import pymysql
from sklearn.model_selection import train_test_split
from sklearn.naive_bayes import GaussianNB
from sklearn.metrics import classification_report, confusion_matrix

app = Flask(__name__)

# Route untuk analisis data wisata
@app.route('/analyze', methods=['GET'])
def analyze_data():
    # Koneksi ke database
    connection = pymysql.connect(
        host='localhost',
        user='root',
        password='',
        db='dashboardpariwisata'
    )

    # Load data dari database
    query = "SELECT * FROM `data-pariwisata`"
    data = pd.read_sql(query, connection)

    # Menutup koneksi
    connection.close()

    # Mengonversi kolom 'jumlah_wisatawan' menjadi numerik
    data['jumlah_wisatawan'] = pd.to_numeric(data['jumlah_wisatawan'], errors='coerce')

    # Menentukan threshold untuk klasifikasi destinasi sebagai 'populer' atau 'tidak populer'
    threshold = 5000

    # Buat variabel target biner
    data['populer'] = data['jumlah_wisatawan'].apply(lambda x: 1 if x > threshold else 0)

    # Pilih fitur yang akan digunakan
    features = data.drop(columns=['id', 'jumlah_wisatawan', 'populer'])

    # Encoding fitur kategorikal
    features = pd.get_dummies(features, drop_first=True)

    # Siapkan variabel target
    target = data['populer']

    # Bagi data menjadi data pelatihan dan data uji
    X_train, X_test, y_train, y_test = train_test_split(features, target, test_size=0.2, random_state=42)

    # Inisialisasi model Naive Bayes
    nb_model = GaussianNB()

    # Latih model
    nb_model.fit(X_train, y_train)

    # Lakukan prediksi pada data uji
    y_pred = nb_model.predict(X_test)

    # Buat laporan klasifikasi dan matriks kebingungan
    report = classification_report(y_test, y_pred, output_dict=True)
    matrix = confusion_matrix(y_test, y_pred).tolist()

    # Filter data untuk rekomendasi destinasi populer dan tidak populer
    recommended_destinations = data[data['populer'] == 1].sort_values(by='jumlah_wisatawan', ascending=False).head(10)
    non_popular_destinations = data[data['populer'] == 0].sort_values(by='jumlah_wisatawan', ascending=True).head(10)

    # Konversi hasil rekomendasi ke JSON
    top_10_recommendations = recommended_destinations[['nama_kabupaten', 'nama_wisata', 'jumlah_wisatawan']].to_dict(orient='records')
    bottom_10_recommendations = non_popular_destinations[['nama_kabupaten', 'nama_wisata', 'jumlah_wisatawan']].to_dict(orient='records')

    # Hitung distribusi destinasi wisata populer vs tidak populer
    distribution = data['populer'].value_counts(normalize=True).to_dict()

    return jsonify({
        'classification_report': report,
        'confusion_matrix': matrix,
        'top_10_recommendations': top_10_recommendations,
        'bottom_10_recommendations': bottom_10_recommendations,
        'distribution': distribution
    })

# Route untuk pencarian tempat wisata berdasarkan nama kabupaten
@app.route('/search', methods=['GET'])
def search():
    kabupaten = request.args.get('kabupaten')

    # Koneksi ke database
    connection = pymysql.connect(
        host='localhost',
        user='root',
        password='',
        db='dashboardpariwisata'
    )

    # Query untuk mencari tempat wisata berdasarkan nama kabupaten
    query = f"SELECT * FROM `data-pariwisata` WHERE `nama_kabupaten` LIKE '%{kabupaten}%'"
    data = pd.read_sql(query, connection)

    # Menutup koneksi
    connection.close()

    # Konversi hasil pencarian ke format JSON
    results = data[['nama_kabupaten', 'nama_wisata', 'jumlah_wisatawan']].to_dict(orient='records')

    return jsonify({'results': results})

if __name__ == '__main__':
    app.run(debug=True)
