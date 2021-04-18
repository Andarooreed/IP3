import os
from random import randint
from shutil import copy, rmtree

def folder_fixer(source_location):
    root_folder_path= "Scripts/working_directory"
    source_folder_path = source_location.replace("XXX","/")
    source_folder = os.path.basename(os.path.normpath(source_folder_path))
    target_folder_path = root_folder_path + "/" + source_folder

    source_folder_parts = source_folder.split("-")

    # Clear down if exists then generate directory structure
    if os.path.exists(target_folder_path):
        rmtree(target_folder_path)

    try:
        os.mkdir(target_folder_path)

        os.mkdir(target_folder_path + "/test")
        os.mkdir(target_folder_path + "/train")

        os.mkdir(target_folder_path + "/test/_standard")
        os.mkdir(target_folder_path + "/train/_standard")

        os.mkdir(target_folder_path + "/test/" + source_folder_parts[2].lower())
        os.mkdir(target_folder_path + "/train/" + source_folder_parts[2].lower())
    except Exception:
        pass

    # Sort out train/test image split
    train_split = 0.2
    source_images = os.listdir(source_folder_path)
    source_count = len(source_images)
    test_count = round(train_split * source_count)
    train_count = source_count - test_count

    # Transfer appropriate amount of standard images
    standard_images = os.listdir(root_folder_path + "/00000-Standard-Standard")

    # Get starting point in standard and loopdy doopdy doo
    sel_start = randint(0,len(standard_images) - source_count - 5)

    i = 0
    while i < train_count:
        src_std = root_folder_path + "/00000-Standard-Standard/" + standard_images[sel_start + i]
        dst_std = target_folder_path + "/train/_standard/" + standard_images[sel_start + i]
        copy(src_std, dst_std)
        i += 1

    tmp_test_count = test_count + i
    while i < tmp_test_count:
        src_std = root_folder_path + "/00000-Standard-Standard/" + standard_images[sel_start + i]
        dst_std = target_folder_path + "/test/_standard/" + standard_images[sel_start + i]
        copy(src_std, dst_std)
        i += 1

    # Transfer user images
    i = 0
    while i < train_count:
        src_usr = source_folder_path + "/" + source_images[i]
        dst_usr = target_folder_path + "/train/" + source_folder_parts[2].lower() + "/" + source_images[i]
        copy(src_usr, dst_usr)
        i += 1

    tmp_test_count = test_count + i
    while i < tmp_test_count:
        src_usr = source_folder_path + "/" + source_images[i]
        dst_usr = target_folder_path + "/test/" + source_folder_parts[2].lower() + "/" + source_images[i]
        copy(src_usr, dst_usr)
        i += 1

    # Whilst we're here, clear callbacks
    if os.path.exists("Scripts/models/callbacks/"):
        rmtree("Scripts/models/callbacks/")
        os.mkdir("Scripts/models/callbacks/")

    # Set retuns
    data = {
        "test_path":  target_folder_path + "/test"
        ,"train_path": target_folder_path + "/train"
        ,"source_full": source_folder
        # ,"source_label": source_folder_parts[2].lower() -- cant remember why this is forced to lower and it's causin me issues
        ,"source_label": source_folder_parts[2]
        ,"source_id": str(source_folder_parts[0])
        ,"source_user": source_folder_parts[1].lower()

    }
   
    return data

 