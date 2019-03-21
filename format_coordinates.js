db = conn.getDB("haunted");
coll = db.getCollection("places");
cur = coll.find();

loc = 0;
city = 0;

print("Running...");
while (cur.hasNext()) {
  doc = cur.next();

  if (doc.longitude && doc.latitude) {
    coll.update({_id: doc._id}, {
      $set: {
        coordinates: {
          type: "Point",
          coordinates: [doc.longitude, doc.latitude]
        }
      },
      $unset: {
        longitude: '',
        latitude: ''
      }
    });
    loc++;
  }
  if (doc.city_longitude && doc.city_latitude) {
    coll.update({_id: doc._id}, {
      $set: {
        city_coordinates: {
          type: "Point",
          coordinates: [doc.city_longitude, doc.city_latitude]
        }
      },
      $unset: {
        city_longitude: '',
        city_latitude: ''
      }
    });
    city++;
  }
}

print("Done!", loc, "locations updated and", city, "cities updated.");
