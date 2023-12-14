-- Query 1
INSERT INTO clients (clientFirstname, clientLastname, clientEmail, clientPassword, comment) VALUES ('Tony', 'Stark', 'tony@starkent.com', 'Iam1ronM@n', "I am the real Ironman");

--Query 2
UPDATE clients SET clientLevel = 3 WHERE clientId = 1;

--Query 3
UPDATE inventory
SET invDescription = REPLACE("Do you have 6 kids and like to go off-roading? The Hummer gives you the small interiors with an engine to get you out of any muddy or rocky situation.", "small", "spacious")
WHERE invModel = "Hummer";

-- Query 4
SELECT inventory.invModel, carclassification.classificationName
FROM inventory
INNER JOIN carclassification 
ON inventory.classificationId = carclassification.classificationId
WHERE carclassification.classificationId = 1;

-- Query 5
DELETE FROM inventory WHERE invModel = "Wrangler";

-- Query 6
UPDATE inventory 
SET invImage=concat('/phpmotors',invImage), invThumbnail=concat('/phpmotors', invThumbnail);

-- Enhancement 8 (These only kind of works because the image names aren't perfect)
UPDATE inventory SET invImage = concat("/phpmotors/images/vehicles/", LOWER((SELECT invModel)), ".jpg");

UPDATE inventory SET invThumbnail = concat("/phpmotors/images/vehicles/", LOWER((SELECT invModel)), "-tn.jpg");
