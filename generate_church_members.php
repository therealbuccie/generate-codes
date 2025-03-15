<?php
require 'vendor/autoload.php';
use Faker\Factory;

// Function to generate a unique filename
function getUniqueFilename($baseName, $extension) {
    $counter = 1;
    do {
        $filename = "{$baseName}_{$counter}.{$extension}";
        $counter++;
    } while (file_exists($filename));
    return $filename;
}

// Set the base filename and extension
$baseFilename = 'church_database';
$extension = 'csv';
$filename = getUniqueFilename($baseFilename, $extension);

// Open the file for writing
$file = fopen($filename, 'w');

// Write the header
fputcsv($file, ['id', 'title', 'country', 'email', 'name', 'password', 'status', 'online', 'last_login', 'participants', 'last_seen', 'uid', 'city', 'ministry', 'position']);

// Create a Faker instance
$faker = Factory::create();

// Titles & Church Positions
$titles = ['Pastor', 'Reverend', 'Bishop', 'Evangelist', 'Minister', 'Father', 'Apostle', 'Prophet'];
$positions = ['Senior Pastor', 'Youth Pastor', 'Worship Leader', 'Deacon', 'Elder', 'Missionary', 'Church Secretary', 'Prayer Coordinator'];

// Church Ministries (Realistic Church Names)
$churches = [
    'Living Faith Church', 'Grace Community Church', 'Holy Spirit Cathedral', 'Redeemed Christian Church', 
    'New Life Ministries', 'Kingdom Assembly', 'Bethlehem Baptist Church', 'Hope Chapel International', 
    'Christ Embassy', 'Victory Outreach Church', 'River of Life Ministries', 'Calvary Chapel', 'Jesus House', 
    'Global Harvest Church', 'Evangel Temple', 'Fire & Glory Church', 'Word of Faith Ministries'
];

// Email Domains (Real & Custom)
$popular_providers = ['gmail.com', 'yahoo.com', 'hotmail.com', 'outlook.com', 'icloud.com', 'mail.com'];
$custom_domains = ['faithministry.net', 'gospelhub.com', 'holychurch.com', 'globalministry.net'];

for ($i = 1; $i <= 100000; $i++) {
    $id = $i;
    $title = $titles[array_rand($titles)];
    $first_name = $faker->firstName;
    $last_name = $faker->lastName;
    $full_name = "{$first_name} {$last_name}";
    $country = $faker->country;
    $city = $faker->city;
    $ministry = $churches[array_rand($churches)];
    $position = $positions[array_rand($positions)];
    
    // Generate a realistic email
    $email_domain = (mt_rand(1, 100) <= 15) ? $custom_domains[array_rand($custom_domains)] : $popular_providers[array_rand($popular_providers)];
    $email_formats = [
        strtolower($first_name) . '.' . strtolower($last_name) . '@' . $email_domain,
        strtolower($last_name) . '_' . strtolower($first_name) . '@' . $email_domain,
        strtolower($first_name[0]) . strtolower($last_name) . '@' . $email_domain
    ];
    $email = $email_formats[array_rand($email_formats)];

    // Default values for other fields
    $password = null;
    $status = 1;
    $online = 0;
    $last_login = $faker->dateTimeBetween('-1 year', 'now')->format('d-M-y');
    $participants = mt_rand(0, 50);
    $last_seen = $faker->dateTimeBetween('-6 months', 'now')->format('d-M-y');
    $uid = $faker->uuid;

    // Write to CSV
    fputcsv($file, [$id, $title, $country, $email, $full_name, $password, $status, $online, $last_login, $participants, $last_seen, $uid, $city, $ministry, $position]);
}

// Close the file
fclose($file);

echo "✅ CSV file '{$filename}' generated with 100,000 records!";
?>
