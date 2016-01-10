//
//  RideDetailViewController.swift
//  GoPool
//
//  Created by Nikhil Kulkarni on 1/7/16.
//  Copyright © 2016 Nikhil Kulkarni. All rights reserved.
//

import UIKit
import GoogleMaps
import SwiftyJSON

class RideDetailViewController: UIViewController {

    @IBOutlet var mapView: GMSMapView!
    @IBOutlet var requestRide: UIButton!
    @IBOutlet var tableView: UITableView!
    
    var ride: JSON!
    
    override func viewDidLoad() {
        super.viewDidLoad()
        
        // 62, 70, 75
        self.navigationController?.navigationBar.barTintColor = UIColor(red: 62/255.0, green: 70/255.0, blue: 75/255.0, alpha: 1.0)
        self.navigationController?.navigationBar.tintColor = UIColor.whiteColor()
        
        requestRide.layer.cornerRadius = 3.0
        tableView.delegate = self
        tableView.dataSource = self
        
        let nib = UINib(nibName: "RideDetailCell", bundle: nil)
        tableView.registerNib(nib, forCellReuseIdentifier: "driverDetail")
        
        let latitude = self.ride["m_latitude"].stringValue.doubleValue
        let longitude = self.ride["m_longitude"].stringValue.doubleValue

        let location = CLLocationCoordinate2DMake(latitude, longitude)
        
        let marker = GMSMarker(position: location)
        marker.icon = UIImage(named: "marker.png")
        marker.title = "Meetup Point"
        marker.map = self.mapView
        
        let cameraPos = GMSCameraPosition(target: location, zoom: 16.0, bearing: 0.0, viewingAngle: 0.0)
        self.mapView.camera = cameraPos

        // Do any additional setup after loading the view.
    }

    override func didReceiveMemoryWarning() {
        super.didReceiveMemoryWarning()
        // Dispose of any resources that can be recreated.
    }
    
    @IBAction func requestRide(sender: AnyObject) {
        
    }
}

extension RideDetailViewController: UITableViewDelegate, UITableViewDataSource {
    
    func numberOfSectionsInTableView(tableView: UITableView) -> Int {
        return 1
    }
    
    func tableView(tableView: UITableView, numberOfRowsInSection section: Int) -> Int {
        return 4
    }
    
    func tableView(tableView: UITableView, cellForRowAtIndexPath indexPath: NSIndexPath) -> UITableViewCell {
        let cell = tableView.dequeueReusableCellWithIdentifier("driverDetail") as! RideDetailCellTableViewCell
        if (indexPath.row == 0) {
            cell.nameLabel.text = self.ride["first_name"].stringValue + " " + self.ride["last_name"].stringValue
            cell.typeLabel.text = "Driver:"
        }
        if (indexPath.row == 1) {
            cell.nameLabel.text = self.ride["major"].stringValue
            cell.typeLabel.text = "Major:"
        }
        if (indexPath.row == 2) {
            cell.nameLabel.text = self.ride["origin"].stringValue
            cell.typeLabel.text = "Origin:"
        }
        if (indexPath.row == 3) {
            cell.nameLabel.text = self.ride["meetup_point"].stringValue
            cell.typeLabel.text = "Meetup Point:"
        }
        return cell
    }
}

extension String {
    var doubleValue: Double {
        return (self as NSString).doubleValue
    }
}
