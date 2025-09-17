<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class HotelController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    public function index()
    {
        $hotels = Hotel::all();
        
        return response()->json([
            'success' => true,
            'data' => $hotels
        ]);
    }

    public function store(Request $request)
    {
        Log::info('=== DÉBUT REQUÊTE CRÉATION HÔTEL ===');
        Log::info('Request data:', $request->all());

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price_per_night' => 'required|numeric|min:0',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:5120',
        ]);

        if ($validator->fails()) {
            Log::error('ERREURS VALIDATION: ', $validator->errors()->toArray());
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $imagePath = null;

        try {
            // Gestion du fichier image
            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('hotels', 'public');
                Log::info('Image stockée temporairement: ' . $imagePath);
            }

            // Création de l'hôtel
            $hotelData = [
                'name' => $request->name,
                'city' => $request->city,
                'country' => $request->country,
                'description' => $request->description,
                'price_per_night' => $request->price_per_night,
            ];

            // Ajouter le chemin de l'image si elle existe
            if ($imagePath) {
                $hotelData['image'] = $imagePath;
            }

            $hotel = Hotel::create($hotelData);

            Log::info('✅ Hôtel créé avec succès:', $hotel->toArray());
            
            return response()->json([
                'success' => true,
                'data' => $hotel,
                'message' => 'Hôtel créé avec succès'
            ], 201);

        } catch (\Exception $e) {
            // En cas d'erreur : supprimer l'image stockée
            if ($imagePath && Storage::disk('public')->exists($imagePath)) {
                Storage::disk('public')->delete($imagePath);
                Log::info('❌ Image supprimée suite à erreur: ' . $imagePath);
            }

            Log::error('❌ Erreur création: ' . $e->getMessage());
            Log::error('Trace: ' . $e->getTraceAsString());
            
            return response()->json([
                'success' => false,
                'message' => 'Erreur serveur: ' . $e->getMessage()
            ], 500);
        }
    }

    public function show($id)
    {
        $hotel = Hotel::find($id);

        if (!$hotel) {
            return response()->json([
                'success' => false,
                'message' => 'Hôtel non trouvé'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $hotel
        ]);
    }
    public function update(Request $request, $id)
{
    Log::info('=== DÉBUT REQUÊTE MISE À JOUR HÔTEL ===');
    Log::info('Request data:', $request->all());

    $hotel = Hotel::find($id);

    if (!$hotel) {
        Log::error('Hôtel non trouvé: ID ' . $id);
        return response()->json([
            'success' => false,
            'message' => 'Hôtel non trouvé'
        ], 404);
    }

    // Règles de validation conditionnelles
    $rules = [];
    $messages = [];

    if ($request->has('name')) {
        $rules['name'] = 'string|max:255';
        $messages['name.string'] = 'Le nom doit être une chaîne';
        $messages['name.max'] = 'Le nom ne doit pas dépasser 255 caractères';
    }

    if ($request->has('city')) {
        $rules['city'] = 'string|max:255';
        $messages['city.string'] = 'La ville doit être une chaîne';
        $messages['city.max'] = 'La ville ne doit pas dépasser 255 caractères';
    }

    if ($request->has('country')) {
        $rules['country'] = 'string|max:255';
        $messages['country.string'] = 'Le pays doit être une chaîne';
        $messages['country.max'] = 'Le pays ne doit pas dépasser 255 caractères';
    }

    if ($request->has('price_per_night')) {
        $rules['price_per_night'] = 'numeric|min:0';
        $messages['price_per_night.numeric'] = 'Le prix doit être un nombre';
        $messages['price_per_night.min'] = 'Le prix ne peut pas être négatif';
    }

    if ($request->hasFile('image')) {
        $rules['image'] = 'image|mimes:jpg,jpeg,png|max:5120';
        $messages['image.image'] = 'Le fichier doit être une image';
        $messages['image.mimes'] = 'L\'image doit être au format JPG, JPEG ou PNG';
        $messages['image.max'] = 'L\'image ne doit pas dépasser 5MB';
    }

    // Valider les champs présents
    $validator = Validator::make($request->all(), $rules, $messages);

    if ($validator->fails()) {
        Log::error('ERREURS VALIDATION: ', $validator->errors()->toArray());
        return response()->json([
            'success' => false,
            'errors' => $validator->errors()
        ], 422);
    }

    try {
        // Mettre à jour les champs présents
        $data = $request->only(['name', 'city', 'country', 'description', 'price_per_night']);
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('hotels', 'public');
            $data['image'] = $path;
            Log::info('Image stockée: ' . $path);
        }

        Log::info('Données à mettre à jour:', $data);

        $hotel->update($data);

        Log::info('✅ Hôtel mis à jour avec succès:', $hotel->toArray());

        return response()->json([
            'success' => true,
            'data' => $hotel,
            'message' => 'Hôtel mis à jour avec succès'
        ]);

    } catch (\Exception $e) {
        Log::error('❌ Erreur mise à jour: ' . $e->getMessage());
        Log::error('Trace: ' . $e->getTraceAsString());
        return response()->json([
            'success' => false,
            'message' => 'Erreur serveur: ' . $e->getMessage()
        ], 500);
    }
}
    
    public function destroy($id)
    {
        $hotel = Hotel::find($id);

        if (!$hotel) {
            return response()->json([
                'success' => false,
                'message' => 'Hôtel non trouvé'
            ], 404);
        }

        try {
            // Supprimer l'image associée
            if ($hotel->image && Storage::disk('public')->exists($hotel->image)) {
                Storage::disk('public')->delete($hotel->image);
                Log::info('Image supprimée: ' . $hotel->image);
            }

            $hotel->delete();

            return response()->json([
                'success' => true,
                'message' => 'Hôtel supprimé avec succès'
            ]);

        } catch (\Exception $e) {
            Log::error('❌ Erreur suppression: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Erreur serveur: ' . $e->getMessage()
            ], 500);
        }
    }
}