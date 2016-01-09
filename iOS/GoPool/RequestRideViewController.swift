//
//  RequestRideViewController.swift
//  GoPool
//
//  Created by Nikhil Kulkarni on 1/6/16.
//  Copyright © 2016 Nikhil Kulkarni. All rights reserved.
//

import UIKit
import GoogleMaps
import SwiftyJSON

class RequestRideViewController: UIViewController {
    
    var resultsViewController: GMSAutocompleteResultsViewController?
    var searchController: UISearchController?
    var resultView: UITextView?
    
    var activityIndicator: UIActivityIndicatorView!
    var grayView: UIView!

    @IBOutlet var tableView: UITableView!
    
    var rides: JSON!
    
    override func viewDidLoad() {
        super.viewDidLoad()
        
        resultsViewController = GMSAutocompleteResultsViewController()
        resultsViewController?.delegate = self
        
        searchController = UISearchController(searchResultsController: resultsViewController)
        searchController?.searchResultsUpdater = resultsViewController
        
        searchController?.searchBar.sizeToFit()
        self.navigationItem.titleView = searchController?.searchBar
        
        self.navigationController?.navigationBar.barTintColor = UIColor(red: 62/255.0, green: 70/255.0, blue: 75/255.0, alpha: 1.0)
//        searchController?.searchBar.backgroundColor = UIColor(red: 62/255.0, green: 70/255.0, blue: 75/255.0, alpha: 1.0)
        searchController?.searchBar.barTintColor = UIColor(red: 62/255.0, green: 70/255.0, blue: 75/255.0, alpha: 1.0)
        searchController?.searchBar.tintColor = UIColor.whiteColor()
        
        self.definesPresentationContext = true
        
        searchController?.hidesNavigationBarDuringPresentation = false
        
        tableView.dataSource = self
        tableView.delegate = self
        
        rides = JSON!(nil)
        
        activityIndicator = UIActivityIndicatorView(activityIndicatorStyle: UIActivityIndicatorViewStyle.Gray)
        activityIndicator.frame = CGRectMake(self.view.frame.width / 2 - 25, self.view.frame.height / 2 - 25, 50, 50)
        grayView = UIView(frame: self.view.frame)
        grayView.backgroundColor = UIColor.lightGrayColor()
        grayView.alpha = 0.3
        // Do any additional setup after loading the view.
    }

    override func didReceiveMemoryWarning() {
        super.didReceiveMemoryWarning()
        // Dispose of any resources that can be recreated.
    }
    
    func alert(message: String) {
        let cancel = UIAlertAction(title: "Ok", style: UIAlertActionStyle.Cancel, handler: nil)
        let alertCon = UIAlertController(title: "Error", message: message, preferredStyle: UIAlertControllerStyle.Alert)
        alertCon.addAction(cancel)
        self.presentViewController(alertCon, animated: true, completion: nil)
    }

}

extension RequestRideViewController: GMSAutocompleteResultsViewControllerDelegate {
    func resultsController(resultsController: GMSAutocompleteResultsViewController!, didAutocompleteWithPlace place: GMSPlace!) {
        searchController?.active = false
        print("Place name: ", place.name)
        print("Place address: ", place.formattedAddress)
        print("Place attributions: ", place.attributions)
        
        self.view.addSubview(grayView)
        self.view.addSubview(activityIndicator)
        activityIndicator.startAnimating()
        
        let url = "http://localhost:63342/GoPool/PHP/findDestination.php?destination=\(place.formattedAddress!)"
        let f = url.stringByReplacingOccurrencesOfString(" ", withString: "%20")
        let request = NSMutableURLRequest(URL: NSURL(string: f)!)
        request.HTTPMethod = "GET"
        let session = NSURLSession.sharedSession()
        let task = session.dataTaskWithRequest(request) { (data, response, error) -> Void in
            let json = JSON(data: data!)
            if (json["status"] == 400) {
                dispatch_async(dispatch_get_main_queue(), { () -> Void in
                    self.activityIndicator.stopAnimating()
                    self.grayView.removeFromSuperview()
                    self.alert("Error. Please try Again")
                })
            } else {
                self.rides = json
                dispatch_async(dispatch_get_main_queue(), { () -> Void in
                    self.tableView.reloadData()
                    self.activityIndicator.stopAnimating()
                    self.grayView.removeFromSuperview()
                })
            }
        }
        task.resume()
    }
    
    func resultsController(resultsController: GMSAutocompleteResultsViewController!, didFailAutocompleteWithError error: NSError!) {
        print("Error: ", error.description)
    }
}

extension RequestRideViewController: UITableViewDataSource, UITableViewDelegate {
    func numberOfSectionsInTableView(tableView: UITableView) -> Int {
        return 1
    }
    
    func tableView(tableView: UITableView, numberOfRowsInSection section: Int) -> Int {
        if (rides == nil) {
            return 0
        } else {
            return self.rides["rides"].count
        }
    }
    
    func tableView(tableView: UITableView, cellForRowAtIndexPath indexPath: NSIndexPath) -> UITableViewCell {
        let cell = tableView.dequeueReusableCellWithIdentifier("cell")
        var text = self.rides["rides"][indexPath.row]["first_name"].stringValue
        text += " " + self.rides["rides"][indexPath.row]["last_name"].stringValue
        cell?.textLabel?.text = text
        return cell!
    }
    
    func tableView(tableView: UITableView, didSelectRowAtIndexPath indexPath: NSIndexPath) {
        tableView.deselectRowAtIndexPath(indexPath, animated: true)
        self.performSegueWithIdentifier("showRideDetail", sender: indexPath.row)
    }
    
    override func prepareForSegue(segue: UIStoryboardSegue, sender: AnyObject?) {
        if segue.identifier == "showRideDetail" {
            let dt = segue.destinationViewController as! RideDetailViewController
            dt.ride = self.rides["rides"][sender as! Int]
        }
    }
}
