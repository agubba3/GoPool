//
//  SignInRiderViewController.swift
//  GoPool
//
//  Created by Nikhil Kulkarni on 1/5/16.
//  Copyright © 2016 Nikhil Kulkarni. All rights reserved.
//

import UIKit
import SwiftyJSON

class SignInRiderViewController: UIViewController {

    @IBOutlet var emailField: UITextField!
    @IBOutlet var passwordField: UITextField!
    var activityIndicator: UIActivityIndicatorView!
    var grayView: UIView!
    
    override func viewDidLoad() {
        super.viewDidLoad()
        
//        var rect = CGRectMake(0, 0, self.view.width, self.view.height)
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
    
    @IBAction func signIn(sender: AnyObject) {
        if (emailField.text == "") {
            self.alert("Enter your email")
        }
        else if (passwordField.text == "") {
            self.alert("Enter your password")
        } else {
            self.view.addSubview(grayView)
            self.view.addSubview(activityIndicator)
            activityIndicator.startAnimating()
            let url = "http://localhost:63342/GoPool/PHP/login.php?email=\(emailField.text!)&pass=\(passwordField.text!)"
            let request = NSMutableURLRequest(URL: NSURL(string: url)!)
            request.HTTPMethod = "GET"
            let session = NSURLSession.sharedSession()
            let task = session.dataTaskWithRequest(request, completionHandler: { (data, response, error) -> Void in
                let json = JSON(data: data!)
                print(json)
                if (json["status"]  == 400) {
                    dispatch_async(dispatch_get_main_queue(), { () -> Void in
                        self.activityIndicator.stopAnimating()
                        self.grayView.removeFromSuperview()
                        self.alert("Invalid Credentials")
                    })
                } else {
                    dispatch_async(dispatch_get_main_queue(), { () -> Void in
                        self.activityIndicator.stopAnimating()
                        self.grayView.removeFromSuperview()
                        self.performSegueWithIdentifier("riderLoggedIn", sender: nil)
                    })
                }
            })
            task.resume()
        }
    }
    
    func alert(message: String) {
        let cancel = UIAlertAction(title: "Ok", style: UIAlertActionStyle.Cancel, handler: nil)
        let alertCon = UIAlertController(title: "Error", message: message, preferredStyle: UIAlertControllerStyle.Alert)
        alertCon.addAction(cancel)
        self.presentViewController(alertCon, animated: true, completion: nil)
    }

    /*
    // MARK: - Navigation

    // In a storyboard-based application, you will often want to do a little preparation before navigation
    override func prepareForSegue(segue: UIStoryboardSegue, sender: AnyObject?) {
        // Get the new view controller using segue.destinationViewController.
        // Pass the selected object to the new view controller.
    }
    */

}
