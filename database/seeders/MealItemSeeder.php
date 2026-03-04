<?php

namespace Database\Seeders;

use App\Models\Meals\MealItem;
use Illuminate\Database\Seeder;

class MealItemSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            // فطار / حبوب ومنتجات ألبان
            ['name' => ['ar' => 'شوفان', 'en' => 'Oats'], 'calories' => 389, 'protein' => 16.9, 'carbohydrates' => 66.3, 'fats' => 6.9],
            ['name' => ['ar' => 'خبز أبيض', 'en' => 'White Bread'], 'calories' => 265, 'protein' => 9.2, 'carbohydrates' => 49.4, 'fats' => 3.2],
            ['name' => ['ar' => 'خبز أسمر', 'en' => 'Brown Bread'], 'calories' => 247, 'protein' => 8.4, 'carbohydrates' => 47.8, 'fats' => 2.8],
            ['name' => ['ar' => 'جبنة بيضاء', 'en' => 'White Cheese'], 'calories' => 264, 'protein' => 18.3, 'carbohydrates' => 3.2, 'fats' => 20.2],
            ['name' => ['ar' => 'جبنة قريش', 'en' => 'Cottage Cheese'], 'calories' => 98, 'protein' => 11.1, 'carbohydrates' => 3.4, 'fats' => 4.3],
            ['name' => ['ar' => 'لبن زبادي', 'en' => 'Yogurt'], 'calories' => 59, 'protein' => 10.2, 'carbohydrates' => 3.5, 'fats' => 0.4],
            ['name' => ['ar' => 'لبن رائب', 'en' => 'Labneh'], 'calories' => 62, 'protein' => 3.5, 'carbohydrates' => 3.2, 'fats' => 3.9],
            ['name' => ['ar' => 'حليب كامل الدسم', 'en' => 'Whole Milk'], 'calories' => 61, 'protein' => 3.2, 'carbohydrates' => 4.8, 'fats' => 3.3],
            ['name' => ['ar' => 'حليب قليل الدسم', 'en' => 'Low-Fat Milk'], 'calories' => 41, 'protein' => 3.4, 'carbohydrates' => 5.0, 'fats' => 1.0],
            ['name' => ['ar' => 'بيض مسلوق', 'en' => 'Boiled Egg'], 'calories' => 155, 'protein' => 12.6, 'carbohydrates' => 1.1, 'fats' => 10.6],
            ['name' => ['ar' => 'بيض مقلي', 'en' => 'Fried Egg'], 'calories' => 196, 'protein' => 13.6, 'carbohydrates' => 0.8, 'fats' => 15.3],
            ['name' => ['ar' => 'عسل', 'en' => 'Honey'], 'calories' => 304, 'protein' => 0.3, 'carbohydrates' => 82.4, 'fats' => 0],
            ['name' => ['ar' => 'مربى', 'en' => 'Jam'], 'calories' => 278, 'protein' => 0.4, 'carbohydrates' => 68.9, 'fats' => 0.1],
            ['name' => ['ar' => 'زبدة', 'en' => 'Butter'], 'calories' => 717, 'protein' => 0.9, 'carbohydrates' => 0.1, 'fats' => 81.1],
            ['name' => ['ar' => 'فول مدمس', 'en' => 'Fava Beans'], 'calories' => 110, 'protein' => 7.6, 'carbohydrates' => 17.6, 'fats' => 0.4],
            ['name' => ['ar' => 'حمص', 'en' => 'Chickpeas'], 'calories' => 164, 'protein' => 8.9, 'carbohydrates' => 27.4, 'fats' => 2.6],
            ['name' => ['ar' => 'طحينة', 'en' => 'Tahini'], 'calories' => 595, 'protein' => 17.0, 'carbohydrates' => 21.2, 'fats' => 53.8],
            ['name' => ['ar' => 'جبنة فيتا', 'en' => 'Feta Cheese'], 'calories' => 264, 'protein' => 14.2, 'carbohydrates' => 4.1, 'fats' => 21.3],
            ['name' => ['ar' => 'كورن فليكس', 'en' => 'Corn Flakes'], 'calories' => 357, 'protein' => 7.5, 'carbohydrates' => 84.1, 'fats' => 0.9],
            ['name' => ['ar' => 'بان كيك', 'en' => 'Pancake'], 'calories' => 227, 'protein' => 6.4, 'carbohydrates' => 28.3, 'fats' => 9.4],
            // غداء / لحوم وأسماك
            ['name' => ['ar' => 'صدر دجاج مشوي', 'en' => 'Grilled Chicken Breast'], 'calories' => 165, 'protein' => 31.0, 'carbohydrates' => 0, 'fats' => 3.6],
            ['name' => ['ar' => 'فخذ دجاج', 'en' => 'Chicken Thigh'], 'calories' => 209, 'protein' => 26.0, 'carbohydrates' => 0, 'fats' => 10.9],
            ['name' => ['ar' => 'لحم بقري مشوي', 'en' => 'Grilled Beef'], 'calories' => 250, 'protein' => 26.1, 'carbohydrates' => 0, 'fats' => 15.4],
            ['name' => ['ar' => 'لحم مفروم', 'en' => 'Ground Beef'], 'calories' => 259, 'protein' => 17.2, 'carbohydrates' => 0, 'fats' => 20.0],
            ['name' => ['ar' => 'سمك مشوي', 'en' => 'Grilled Fish'], 'calories' => 127, 'protein' => 20.4, 'carbohydrates' => 0, 'fats' => 4.5],
            ['name' => ['ar' => 'سلمون', 'en' => 'Salmon'], 'calories' => 208, 'protein' => 20.4, 'carbohydrates' => 0, 'fats' => 13.4],
            ['name' => ['ar' => 'جمبري', 'en' => 'Shrimp'], 'calories' => 99, 'protein' => 24.0, 'carbohydrates' => 0.2, 'fats' => 0.3],
            ['name' => ['ar' => 'كباب لحم', 'en' => 'Beef Kebab'], 'calories' => 225, 'protein' => 26.0, 'carbohydrates' => 2.5, 'fats' => 12.0],
            ['name' => ['ar' => 'كفتة', 'en' => 'Kofta'], 'calories' => 240, 'protein' => 18.0, 'carbohydrates' => 4.0, 'fats' => 17.0],
            ['name' => ['ar' => 'محشي ورق عنب', 'en' => 'Stuffed Grape Leaves'], 'calories' => 95, 'protein' => 4.0, 'carbohydrates' => 12.0, 'fats' => 3.5],
            ['name' => ['ar' => 'أرز أبيض', 'en' => 'White Rice'], 'calories' => 130, 'protein' => 2.7, 'carbohydrates' => 28.2, 'fats' => 0.3],
            ['name' => ['ar' => 'أرز بسمتي', 'en' => 'Basmati Rice'], 'calories' => 130, 'protein' => 2.7, 'carbohydrates' => 28.2, 'fats' => 0.3],
            ['name' => ['ar' => 'أرز بني', 'en' => 'Brown Rice'], 'calories' => 112, 'protein' => 2.6, 'carbohydrates' => 23.5, 'fats' => 0.9],
            ['name' => ['ar' => 'مكرونة', 'en' => 'Pasta'], 'calories' => 131, 'protein' => 5.0, 'carbohydrates' => 25.1, 'fats' => 1.1],
            ['name' => ['ar' => 'مكرونة سباغيتي', 'en' => 'Spaghetti'], 'calories' => 131, 'protein' => 5.0, 'carbohydrates' => 25.1, 'fats' => 1.1],
            ['name' => ['ar' => 'برغل', 'en' => 'Bulgur'], 'calories' => 83, 'protein' => 3.1, 'carbohydrates' => 18.6, 'fats' => 0.2],
            ['name' => ['ar' => 'كسكس', 'en' => 'Couscous'], 'calories' => 112, 'protein' => 3.8, 'carbohydrates' => 23.2, 'fats' => 0.2],
            ['name' => ['ar' => 'بطاطس مسلوقة', 'en' => 'Boiled Potato'], 'calories' => 87, 'protein' => 1.9, 'carbohydrates' => 20.1, 'fats' => 0.1],
            ['name' => ['ar' => 'بطاطس مقلية', 'en' => 'French Fries'], 'calories' => 312, 'protein' => 3.4, 'carbohydrates' => 41.4, 'fats' => 14.7],
            ['name' => ['ar' => 'بطاطس مشوية', 'en' => 'Baked Potato'], 'calories' => 93, 'protein' => 2.5, 'carbohydrates' => 21.2, 'fats' => 0.1],
            ['name' => ['ar' => 'عدس أصفر', 'en' => 'Yellow Lentils'], 'calories' => 116, 'protein' => 9.0, 'carbohydrates' => 20.1, 'fats' => 0.4],
            ['name' => ['ar' => 'عدس أحمر', 'en' => 'Red Lentils'], 'calories' => 116, 'protein' => 9.0, 'carbohydrates' => 20.1, 'fats' => 0.4],
            ['name' => ['ar' => 'فاصوليا بيضاء', 'en' => 'White Beans'], 'calories' => 139, 'protein' => 9.7, 'carbohydrates' => 25.1, 'fats' => 0.5],
            ['name' => ['ar' => 'لوبيا', 'en' => 'Black-Eyed Peas'], 'calories' => 116, 'protein' => 8.0, 'carbohydrates' => 20.8, 'fats' => 0.5],
            ['name' => ['ar' => 'خضار سوتيه', 'en' => 'Sautéed Vegetables'], 'calories' => 45, 'protein' => 2.2, 'carbohydrates' => 8.0, 'fats' => 0.5],
            ['name' => ['ar' => 'سلطة خضراء', 'en' => 'Green Salad'], 'calories' => 15, 'protein' => 1.2, 'carbohydrates' => 2.9, 'fats' => 0.2],
            ['name' => ['ar' => 'خيار', 'en' => 'Cucumber'], 'calories' => 15, 'protein' => 0.7, 'carbohydrates' => 3.6, 'fats' => 0.1],
            ['name' => ['ar' => 'طماطم', 'en' => 'Tomato'], 'calories' => 18, 'protein' => 0.9, 'carbohydrates' => 3.9, 'fats' => 0.2],
            ['name' => ['ar' => 'خس', 'en' => 'Lettuce'], 'calories' => 15, 'protein' => 1.4, 'carbohydrates' => 2.9, 'fats' => 0.2],
            ['name' => ['ar' => 'جزر', 'en' => 'Carrot'], 'calories' => 41, 'protein' => 0.9, 'carbohydrates' => 9.6, 'fats' => 0.2],
            ['name' => ['ar' => 'بازلاء', 'en' => 'Peas'], 'calories' => 81, 'protein' => 5.4, 'carbohydrates' => 14.5, 'fats' => 0.4],
            ['name' => ['ar' => 'باميا', 'en' => 'Okra'], 'calories' => 33, 'protein' => 1.9, 'carbohydrates' => 7.5, 'fats' => 0.2],
            ['name' => ['ar' => 'باذنجان', 'en' => 'Eggplant'], 'calories' => 25, 'protein' => 1.0, 'carbohydrates' => 6.0, 'fats' => 0.2],
            ['name' => ['ar' => 'كوسة', 'en' => 'Zucchini'], 'calories' => 17, 'protein' => 1.2, 'carbohydrates' => 3.1, 'fats' => 0.3],
            ['name' => ['ar' => 'بروكلي', 'en' => 'Broccoli'], 'calories' => 34, 'protein' => 2.8, 'carbohydrates' => 7.0, 'fats' => 0.4],
            ['name' => ['ar' => 'سبانخ', 'en' => 'Spinach'], 'calories' => 23, 'protein' => 2.9, 'carbohydrates' => 3.6, 'fats' => 0.4],
            ['name' => ['ar' => 'ملوخية', 'en' => 'Molokhia'], 'calories' => 43, 'protein' => 4.5, 'carbohydrates' => 7.0, 'fats' => 0.2],
            ['name' => ['ar' => 'شوربة عدس', 'en' => 'Lentil Soup'], 'calories' => 75, 'protein' => 4.9, 'carbohydrates' => 12.0, 'fats' => 1.2],
            ['name' => ['ar' => 'شوربة خضار', 'en' => 'Vegetable Soup'], 'calories' => 35, 'protein' => 1.8, 'carbohydrates' => 6.5, 'fats' => 0.3],
            ['name' => ['ar' => 'شوربة دجاج', 'en' => 'Chicken Soup'], 'calories' => 45, 'protein' => 4.2, 'carbohydrates' => 4.0, 'fats' => 1.5],
            ['name' => ['ar' => 'حمص بالطحينة', 'en' => 'Hummus'], 'calories' => 166, 'protein' => 7.9, 'carbohydrates' => 14.3, 'fats' => 9.6],
            ['name' => ['ar' => 'فتة', 'en' => 'Fatta'], 'calories' => 185, 'protein' => 8.0, 'carbohydrates' => 22.0, 'fats' => 7.5],
            ['name' => ['ar' => 'مسبحة', 'en' => 'Moussaka'], 'calories' => 95, 'protein' => 4.5, 'carbohydrates' => 12.0, 'fats' => 3.2],
            ['name' => ['ar' => 'محشي كوسة', 'en' => 'Stuffed Zucchini'], 'calories' => 78, 'protein' => 4.2, 'carbohydrates' => 10.0, 'fats' => 2.5],
            ['name' => ['ar' => 'ورق عنب', 'en' => 'Grape Leaves'], 'calories' => 93, 'protein' => 4.0, 'carbohydrates' => 11.5, 'fats' => 3.8],
            // عشاء
            ['name' => ['ar' => 'جبنة ريكوتا', 'en' => 'Ricotta Cheese'], 'calories' => 174, 'protein' => 11.3, 'carbohydrates' => 3.0, 'fats' => 13.0],
            ['name' => ['ar' => 'تونة', 'en' => 'Tuna'], 'calories' => 132, 'protein' => 28.3, 'carbohydrates' => 0, 'fats' => 1.0],
            ['name' => ['ar' => 'سردين', 'en' => 'Sardines'], 'calories' => 208, 'protein' => 24.6, 'carbohydrates' => 0, 'fats' => 11.5],
            ['name' => ['ar' => 'سلطة تونة', 'en' => 'Tuna Salad'], 'calories' => 85, 'protein' => 12.0, 'carbohydrates' => 4.0, 'fats' => 2.5],
            ['name' => ['ar' => 'عصيدة', 'en' => 'Porridge'], 'calories' => 71, 'protein' => 2.5, 'carbohydrates' => 12.0, 'fats' => 1.5],
            ['name' => ['ar' => 'ساندويتش جبن', 'en' => 'Cheese Sandwich'], 'calories' => 285, 'protein' => 12.5, 'carbohydrates' => 28.0, 'fats' => 13.0],
            ['name' => ['ar' => 'ساندويتش لبنة', 'en' => 'Labneh Sandwich'], 'calories' => 195, 'protein' => 8.0, 'carbohydrates' => 25.0, 'fats' => 6.5],
            ['name' => ['ar' => 'فطيرة سبانخ', 'en' => 'Spinach Pie'], 'calories' => 220, 'protein' => 8.0, 'carbohydrates' => 22.0, 'fats' => 11.0],
            ['name' => ['ar' => 'فطيرة جبن', 'en' => 'Cheese Pie'], 'calories' => 315, 'protein' => 12.0, 'carbohydrates' => 28.0, 'fats' => 18.0],
            ['name' => ['ar' => 'بيض بالبطاطس', 'en' => 'Egg with Potato'], 'calories' => 145, 'protein' => 7.5, 'carbohydrates' => 14.0, 'fats' => 6.5],
            // سناكس وحلويات
            ['name' => ['ar' => 'موز', 'en' => 'Banana'], 'calories' => 89, 'protein' => 1.1, 'carbohydrates' => 22.8, 'fats' => 0.3],
            ['name' => ['ar' => 'تفاح', 'en' => 'Apple'], 'calories' => 52, 'protein' => 0.3, 'carbohydrates' => 13.8, 'fats' => 0.2],
            ['name' => ['ar' => 'برتقال', 'en' => 'Orange'], 'calories' => 47, 'protein' => 0.9, 'carbohydrates' => 11.8, 'fats' => 0.1],
            ['name' => ['ar' => 'عنب', 'en' => 'Grapes'], 'calories' => 69, 'protein' => 0.7, 'carbohydrates' => 18.1, 'fats' => 0.2],
            ['name' => ['ar' => 'فراولة', 'en' => 'Strawberry'], 'calories' => 32, 'protein' => 0.7, 'carbohydrates' => 7.7, 'fats' => 0.3],
            ['name' => ['ar' => 'بطيخ', 'en' => 'Watermelon'], 'calories' => 30, 'protein' => 0.6, 'carbohydrates' => 7.6, 'fats' => 0.2],
            ['name' => ['ar' => 'شمام', 'en' => 'Cantaloupe'], 'calories' => 34, 'protein' => 0.8, 'carbohydrates' => 8.2, 'fats' => 0.2],
            ['name' => ['ar' => 'تمر', 'en' => 'Dates'], 'calories' => 282, 'protein' => 2.5, 'carbohydrates' => 75.0, 'fats' => 0.4],
            ['name' => ['ar' => 'تين', 'en' => 'Fig'], 'calories' => 74, 'protein' => 0.8, 'carbohydrates' => 19.2, 'fats' => 0.3],
            ['name' => ['ar' => 'رمان', 'en' => 'Pomegranate'], 'calories' => 83, 'protein' => 1.7, 'carbohydrates' => 18.7, 'fats' => 1.2],
            ['name' => ['ar' => 'كيوي', 'en' => 'Kiwi'], 'calories' => 61, 'protein' => 1.1, 'carbohydrates' => 14.7, 'fats' => 0.5],
            ['name' => ['ar' => 'مانجو', 'en' => 'Mango'], 'calories' => 60, 'protein' => 0.8, 'carbohydrates' => 15.0, 'fats' => 0.4],
            ['name' => ['ar' => 'إجاص', 'en' => 'Pear'], 'calories' => 57, 'protein' => 0.4, 'carbohydrates' => 15.2, 'fats' => 0.1],
            ['name' => ['ar' => 'خوخ', 'en' => 'Peach'], 'calories' => 39, 'protein' => 0.9, 'carbohydrates' => 9.5, 'fats' => 0.3],
            ['name' => ['ar' => 'مشمش', 'en' => 'Apricot'], 'calories' => 48, 'protein' => 1.4, 'carbohydrates' => 11.1, 'fats' => 0.4],
            ['name' => ['ar' => 'جوز', 'en' => 'Walnuts'], 'calories' => 654, 'protein' => 15.2, 'carbohydrates' => 13.7, 'fats' => 65.2],
            ['name' => ['ar' => 'لوز', 'en' => 'Almonds'], 'calories' => 579, 'protein' => 21.2, 'carbohydrates' => 21.6, 'fats' => 49.9],
            ['name' => ['ar' => 'كاجو', 'en' => 'Cashew'], 'calories' => 553, 'protein' => 18.2, 'carbohydrates' => 30.2, 'fats' => 43.8],
            ['name' => ['ar' => 'فستق', 'en' => 'Pistachio'], 'calories' => 560, 'protein' => 20.2, 'carbohydrates' => 27.2, 'fats' => 45.3],
            ['name' => ['ar' => 'بندق', 'en' => 'Hazelnuts'], 'calories' => 628, 'protein' => 15.0, 'carbohydrates' => 16.7, 'fats' => 60.8],
            ['name' => ['ar' => 'فشار', 'en' => 'Popcorn'], 'calories' => 375, 'protein' => 11.0, 'carbohydrates' => 74.0, 'fats' => 4.5],
            ['name' => ['ar' => 'شيبس', 'en' => 'Chips'], 'calories' => 536, 'protein' => 7.0, 'carbohydrates' => 49.7, 'fats' => 35.0],
            ['name' => ['ar' => 'كوكيز', 'en' => 'Cookies'], 'calories' => 502, 'protein' => 5.7, 'carbohydrates' => 65.0, 'fats' => 24.0],
            ['name' => ['ar' => 'كيك شوكولاتة', 'en' => 'Chocolate Cake'], 'calories' => 389, 'protein' => 5.3, 'carbohydrates' => 50.8, 'fats' => 18.5],
            ['name' => ['ar' => 'كنافة', 'en' => 'Kunafa'], 'calories' => 320, 'protein' => 5.5, 'carbohydrates' => 45.0, 'fats' => 13.0],
            ['name' => ['ar' => 'بسبوسة', 'en' => 'Basbousa'], 'calories' => 350, 'protein' => 5.0, 'carbohydrates' => 52.0, 'fats' => 13.0],
            ['name' => ['ar' => 'أم علي', 'en' => 'Umm Ali'], 'calories' => 285, 'protein' => 6.0, 'carbohydrates' => 42.0, 'fats' => 10.0],
            ['name' => ['ar' => 'شوكولاتة داكنة', 'en' => 'Dark Chocolate'], 'calories' => 546, 'protein' => 4.9, 'carbohydrates' => 61.2, 'fats' => 31.3],
            ['name' => ['ar' => 'آيس كريم', 'en' => 'Ice Cream'], 'calories' => 207, 'protein' => 3.5, 'carbohydrates' => 23.6, 'fats' => 11.0],
            ['name' => ['ar' => 'عصير برتقال', 'en' => 'Orange Juice'], 'calories' => 45, 'protein' => 0.7, 'carbohydrates' => 10.4, 'fats' => 0.2],
            ['name' => ['ar' => 'عصير تفاح', 'en' => 'Apple Juice'], 'calories' => 46, 'protein' => 0.1, 'carbohydrates' => 11.4, 'fats' => 0.1],
            ['name' => ['ar' => 'عصير مانجو', 'en' => 'Mango Juice'], 'calories' => 54, 'protein' => 0.3, 'carbohydrates' => 13.4, 'fats' => 0.1],
            ['name' => ['ar' => 'سموذي موز', 'en' => 'Banana Smoothie'], 'calories' => 89, 'protein' => 1.5, 'carbohydrates' => 21.0, 'fats' => 0.4],
            ['name' => ['ar' => 'قهوة', 'en' => 'Coffee'], 'calories' => 2, 'protein' => 0.1, 'carbohydrates' => 0, 'fats' => 0],
            ['name' => ['ar' => 'شاي', 'en' => 'Tea'], 'calories' => 1, 'protein' => 0, 'carbohydrates' => 0.2, 'fats' => 0],
            ['name' => ['ar' => 'لبن', 'en' => 'Milk'], 'calories' => 42, 'protein' => 3.4, 'carbohydrates' => 5.0, 'fats' => 1.0],
            ['name' => ['ar' => 'عصير ليمون', 'en' => 'Lemon Juice'], 'calories' => 22, 'protein' => 0.4, 'carbohydrates' => 6.9, 'fats' => 0.2],
        ];

        if (MealItem::count() > 0) {
            return;
        }

        foreach ($items as $data) {
            MealItem::create(array_merge($data, ['active' => true]));
        }
    }
}
